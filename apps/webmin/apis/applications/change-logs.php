<?php

$data = false;
$events = false;

$type = Input::get('type', null);
$workerId = Input::get('worker_id', 0);

$changeLogs = ChangeLog::whereNull('deleted_at')->where('worker_id', $workerId)->where('type', $type)->get();

$data = [
  'change_logs' => $changeLogs,
  'change_logs_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
