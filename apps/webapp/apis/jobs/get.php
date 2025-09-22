<?php

$data = false;
$events = false;

$id = Input::get('id', 0);

$job = Job::whereNull('deleted_at')->find($id);

if (!$job) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'No job is found',
    ],
  ];
  goto RESPONSE;
}

$data = [
  'job' => $job,
  'job_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
