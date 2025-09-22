<?php

$data = false;
$events = false;

$applications = Application::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($applications as $application) {
  $options[] = [
    'value' => $application->id,
    'label' => $application->title,
  ];
}

$data = [
  'options_applications' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
