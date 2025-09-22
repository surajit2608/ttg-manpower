<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$employments = WorkerEmployment::whereNull('deleted_at')->where('worker_id', $workerId)->get();
$employment = WorkerEmploymentReference::whereNull('deleted_at')->where('worker_id', $workerId)->first();

$data = [
  'employment' => $employment,
  'employments' => $employments,
  'employments_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];