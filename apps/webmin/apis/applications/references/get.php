<?php

$data = false;
$events = false;

$workerId = Input::get('worker_id', 0);

$references = WorkerReference::whereNull('deleted_at')->where('worker_id', $workerId)->get();

$data = [
  'references' => $references,
  'references_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
