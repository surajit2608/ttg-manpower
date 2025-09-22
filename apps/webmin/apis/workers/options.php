<?php

$data = false;
$events = false;

$workers = Worker::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($workers as $worker) {
  $options[] = [
    'value' => $worker->id,
    'label' => $worker->name,
  ];
}

$data = [
  'options_workers' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
