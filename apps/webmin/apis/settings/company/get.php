<?php

$data = false;
$events = false;

$company = Company::whereNull('deleted_at')->find(1);

$data = [
  'company' => $company,
  'company_loaded' => true
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
