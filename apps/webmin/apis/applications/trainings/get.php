<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$trainings = WorkerTraining::whereNull('deleted_at')->where('worker_id', $workerId)->get();

$data = [
  'trainings' => $trainings,
  'trainings_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
