<?php

$data = false;
$events = false;

$rules = [
  'application_id' => 'required',
];

$messages = [
  'application_id:required' => 'Job application selection is required',
];

$errors = Input::validate($rules, $messages);
if ($errors) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => $errors[0],
    ],
  ];
  goto RESPONSE;
}

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$applicationId = Input::get('application_id', 0);
$radiusM = Input::get('radius_m', 0);
if ($radiusM === '') $radiusM = 0;
$fromDate = Input::get('from_date', null);
if (!$fromDate) $fromDate = date('Y-m-d');
$toDate = Input::get('to_date', null);
if (!$toDate) $toDate = date('Y-m-d');

$shiftStartTime = Input::get('shift_start_time', null);
if ($shiftStartTime) {
  $shiftStartTime = date('H:i', strtotime($shiftStartTime));
}

$shiftEndTime = Input::get('shift_end_time', null);
if ($shiftEndTime) {
  $shiftEndTime = date('H:i', strtotime($shiftEndTime));
}


$dayNames = [];
$start = new DateTime($fromDate);
$end = new DateTime($toDate);
$end->modify('+1 day');
$interval = new DateInterval('P1D');
$daterange = new DatePeriod($start, $interval, $end);
foreach ($daterange as $date) {
  $dayNames[$date->format('Y-m-d')] = strtolower($date->format('l'));
}

$application = Application::find($applicationId);
$jobLat = $application->latitude;
$jobLon = $application->longitude;

$nearbyWorkerIds = [];
$nearbyWorkerIdsWithDistance = Address::nearbyWorkerIds($jobLat, $jobLon, $radiusM);
foreach ($nearbyWorkerIdsWithDistance as $workerId => $distance) {
  $nearbyWorkerIds[] = $workerId;
}

$nearbyWorkers = Worker::whereIn('status', ['approved'])
  ->where('application_id', $applicationId)
  ->whereIn('id', $nearbyWorkerIds)
  ->whereNull('deleted_at');

if ($column != 'distance') {
  $nearbyWorkers->orderBy($column, $direction);
}

if ($search) {
  $columns = [
    'account_name',
  ];
  $nearbyWorkers->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalNearbyWorkers = clone $nearbyWorkers;

if ($page != -1) {
  $nearbyWorkers->limit($limit)->skip($skip);
}

$nearbyWorkers = $nearbyWorkers->get();

$nearbyWorkers = deepClone($nearbyWorkers);
foreach ($nearbyWorkers as $nearbyWorker) {
  $nearbyWorker->distance = $nearbyWorkerIdsWithDistance[$nearbyWorker->id] ?? 0;
}

if ($column == 'distance') {
  if ($direction == 'asc') {
    function orderByDistance($a, $b)
    {
      return $a->distance - $b->distance;
    }
  }
  if ($direction == 'desc') {
    function orderByDistance($a, $b)
    {
      return $b->distance - $a->distance;
    }
  }
  usort($nearbyWorkers, 'orderByDistance');
}

foreach ($nearbyWorkers as $nearbyWorker) {
  $nearbyWorker->_availabilities = [];

  foreach ($dayNames as $date => $dayName) {
    $nearbyWorker->_availabilities[$date] = [
      'date' => $date,
      'day' => $dayName,
      'checked' => false,
      'availability' => 'No'
    ];

    $checkWorkerClasses = WorkerClass::where('worker_id', $nearbyWorker->id)
      ->where('start_date', '<=', $date)
      ->where('end_date', '>=', $date)
      ->whereNotNull($dayName . '_start')
      ->whereNotNull($dayName . '_end')
      ->where(function ($query) use (&$dayName, &$shiftStartTime, &$shiftEndTime) {
        if ($shiftStartTime && $shiftEndTime) {
          $query->whereBetween($dayName . '_start', [$shiftStartTime, $shiftEndTime]);
          $query->orWhereBetween($dayName . '_end', [$shiftStartTime, $shiftEndTime]);
        }
      })
      ->whereNull('deleted_at')
      ->count();

    $checkWorkerAvailability = 0;
    if ($shiftStartTime && !$shiftEndTime) {
      $checkWorkerAvailability = WorkerAvailability::where('worker_id', $nearbyWorker->id)
        ->where($dayName . '_from', '<', $shiftStartTime)
        ->whereNull('deleted_at')
        ->count();
    }
    if (!$shiftStartTime && $shiftEndTime) {
      $checkWorkerAvailability = WorkerAvailability::where('worker_id', $nearbyWorker->id)
        ->where($dayName . '_to', '>', $shiftEndTime)
        ->whereNull('deleted_at')
        ->count();
    }
    if ($shiftStartTime && $shiftEndTime) {
      $checkWorkerAvailability = WorkerAvailability::where('worker_id', $nearbyWorker->id)
        ->where(function ($query) use (&$dayName, &$shiftStartTime, &$shiftEndTime) {
          $query->where($dayName . '_from', '<', $shiftStartTime)
            ->where($dayName . '_to', '>', $shiftEndTime);
        })
        ->whereNull('deleted_at')
        ->count();
    }

    $checkWorkerLeave = Leave::with('holiday')
      ->join('holidays', 'leaves.holiday_id', '=', 'holidays.id')
      ->where('leaves.worker_id', $nearbyWorker->id)
      ->where('leaves.status', 'approved')
      ->where('holidays.date', $date)
      ->whereNull('leaves.deleted_at')
      ->count();

    $checkAlreadyAssignment = WorkerAssignment::where('worker_id', $nearbyWorker->id)
      ->where('date', $date)
      ->whereNull('deleted_at')
      ->count();

    $checkTermbreaks = WorkerTermbreak::where('worker_id', $nearbyWorker->id)
      ->where('from', '<=', $date)
      ->where('to', '>=', $date)
      ->whereNull('deleted_at')
      ->count();

    if ((!$checkWorkerClasses && !$checkWorkerAvailability && !$checkWorkerLeave && !$checkAlreadyAssignment) || $checkTermbreaks) {
      $nearbyWorker->_availabilities[$date]['availability'] = 'Yes';
    }
  }
}

$pagination = Pagination::get($page, $limit, count($nearbyWorkers), $totalNearbyWorkers->count());

if (!count($nearbyWorkers)) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'No Workers are found within ' . $radiusM . ' miles radius for this Job',
    ],
  ];
}

$data = [
  'workers_loaded' => true,
  'workers' => $nearbyWorkers,
  'pagination' => $pagination,
  'application' => $application,
  'date_ranges' => $dayNames,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
