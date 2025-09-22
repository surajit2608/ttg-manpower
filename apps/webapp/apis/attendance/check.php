<?php

$data = false;
$events = false;

$date = date('Y-m-d');
$userId = Session::get('user_id', 0);

$attendance = Attendance::whereNull('deleted_at')
  ->where('date', 'LIKE', $date . '%')
  ->where('worker_id', $userId)
  ->first();

$data = [
  'punched' => $attendance,
  'punched_loaded' => true
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
