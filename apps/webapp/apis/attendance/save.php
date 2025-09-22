<?php

$data = false;
$events = false;

$userId = Session::get('user_id', 0);

$rules = [
  'latitude' => 'required',
  'longitude' => 'required',
];

$messages = [
  'latitude:required' => 'Share your location',
  'longitude:required' => 'Share your location',
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

$date = date('Y-m-d');
$note = Input::get('note', null);
$latitude = Input::get('latitude', null);
$longitude = Input::get('longitude', null);

$user = Worker::with('application')->find($userId);
$application = $user->application ?? null;

$jobLatitude = $application->latitude ?? null;
$jobLongitude = $application->longitude ?? null;

$attendance = Attendance::whereNull('deleted_at')
  ->where('worker_id', $userId)
  ->where('date', 'LIKE', $date . '%')
  ->first();

$distance = Address::haversineDistance($jobLatitude, $jobLongitude, $latitude, $longitude);
if ($distance >= 1) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Goto your Workplace before ' . (!$attendance ? 'PunchIn' : 'PunchOut'),
    ],
  ];
  goto RESPONSE;
}

$attendance = Attendance::whereNull('deleted_at')
  ->where('worker_id', $userId)
  ->where('date', 'LIKE', $date . '%')
  ->first();

if ($attendance && $attendance->in_time && $attendance->out_time) {
  goto RESPONSE;
}

$details = (array)($attendance->details ?? []);
if (!$attendance) {
  $attendance = new Attendance;
  $attendance->in_note = $note;
  $attendance->date = date('Y-m-d H:i:s');
  $attendance->in_time = date('Y-m-d H:i:s');
  $attendance->created_at = date('Y-m-d H:i:s');

  $details['in_latitude'] = $latitude;
  $details['in_longitude'] = $longitude;

  $message = 'PunchIn Time successfully saved';
} else {
  $attendance->out_note = $note;
  $attendance->out_time = date('Y-m-d H:i:s');

  $attendance->hours = round((strtotime($attendance->out_time) - strtotime($attendance->in_time)) / 3600, 2);

  $details['out_latitude'] = $latitude;
  $details['out_longitude'] = $longitude;

  $message = 'PunchOut Time successfully saved';
}

$attendance->details = $details;
$attendance->worker_id = $userId;
$attendance->updated_at = date('Y-m-d H:i:s');
$attendance->save();

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => $message,
  ],
];

$data = [
  'punch_note' => '',
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
