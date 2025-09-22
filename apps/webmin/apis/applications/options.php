<?php

$data = false;
$events = false;

$applications = Application::with('client')->whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($applications as $application) {
  $options[] = [
    'value' => $application->id,
    'label' => $application->title . ' / ' . $application->client->business_name,
    'details' => $application->address . ', ' . $application->city . ', ' . $application->post_code . ', ' . $application->country,
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
