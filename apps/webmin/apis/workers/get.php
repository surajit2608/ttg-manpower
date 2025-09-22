<?php

$data = false;
$events = false;

$id = Input::get('id', 0);

$worker = Worker::whereNull('deleted_at')->find($id);

if (!$worker) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'No worker is found',
    ],
  ];
  goto RESPONSE;
}

$data = [
  'worker' => $worker,
  'worker_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
