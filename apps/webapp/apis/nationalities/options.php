<?php

$data = false;
$events = false;

$nationalities = Nationality::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($nationalities as $nationality) {
  $options[] = [
    'value' => $nationality->id,
    'label' => $nationality->name,
  ];
}

$data = [
  'options_nationalities' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
