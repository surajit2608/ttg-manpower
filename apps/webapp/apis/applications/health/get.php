<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$health = WorkerHealth::whereNull('deleted_at')->where('worker_id', $workerId)->first();

$data = [
  'health' => $health,
  'health_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
