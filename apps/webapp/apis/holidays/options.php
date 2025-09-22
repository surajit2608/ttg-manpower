<?php

$data = false;
$events = false;

$holidays = Holiday::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($holidays as $holiday) {
  $options[] = [
    'value' => $holiday->id,
    'label' => $holiday->name,
  ];
}

$data = [
  'options_holidays' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
