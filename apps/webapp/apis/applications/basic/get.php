<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$basic = WorkerBasic::whereNull('deleted_at')->where('worker_id', $workerId)->first();
$class = WorkerClass::whereNull('deleted_at')->where('worker_id', $workerId)->first();
$termbreaks = WorkerTermbreak::whereNull('deleted_at')->where('worker_id', $workerId)->get();
$availability = WorkerAvailability::whereNull('deleted_at')->where('worker_id', $workerId)->first();

$data = [
  'class' => $class,
  'basic' => $basic,
  'termbreaks' => $termbreaks,
  'availability' => $availability,
  'basic_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
