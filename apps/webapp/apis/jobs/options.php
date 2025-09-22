<?php

$data = false;
$events = false;

$jobs = Job::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($jobs as $job) {
  $options[] = [
    'value' => $job->id,
    'label' => $job->name,
  ];
}

$data = [
  'options_jobs' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
