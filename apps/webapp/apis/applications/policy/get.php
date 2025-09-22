<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$policy = WorkerPolicy::whereNull('deleted_at')->where('worker_id', $workerId)->first();

$data = [
  'policy' => $policy,
  'policy_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
