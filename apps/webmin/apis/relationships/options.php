<?php

$data = false;
$events = false;

$relationships = Relationship::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($relationships as $relationship) {
  $options[] = [
    'value' => $relationship->id,
    'label' => $relationship->name,
  ];
}

$data = [
  'options_relationships' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
