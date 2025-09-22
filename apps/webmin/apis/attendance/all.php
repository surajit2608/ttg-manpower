<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$workerId = Input::get('worker_id', 0);
$direction = Input::get('direction', 'desc');

$attendance = Attendance::whereNull('deleted_at')
  ->where('worker_id', $workerId)
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'date',
    'in_time',
    'in_note',
    'out_time',
    'out_note',
    'hours',
  ];
  $attendance->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalAttendance = clone $attendance;

if ($page != -1) {
  $attendance->limit($limit)->skip($skip);
}
$attendance = $attendance->get();

$pagination = Pagination::get($page, $limit, $attendance->count(), $totalAttendance->count());

$data = [
  'attendance' => $attendance,
  'attendance_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
