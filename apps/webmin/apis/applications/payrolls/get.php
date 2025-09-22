<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$payrolls = WorkerPayroll::whereNull('deleted_at')->where('worker_id', $workerId)->get();

$data = [
  'payrolls' => $payrolls,
  'payrolls_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
