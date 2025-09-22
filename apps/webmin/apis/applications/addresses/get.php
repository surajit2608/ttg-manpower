<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$addresses = WorkerAddress::whereNull('deleted_at')->where('worker_id', $workerId)->get();

$data = [
  'addresses' => $addresses,
  'addresses_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
