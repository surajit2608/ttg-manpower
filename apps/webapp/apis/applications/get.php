<?php

$data = false;
$events = false;

$slug = Input::get('slug', null);

$application = Application::with('job')->where('slug', $slug)->whereNull('deleted_at')->first();

$data = [
  'application' => $application,
  'application_loaded' => true,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
