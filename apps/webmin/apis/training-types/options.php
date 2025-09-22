<?php

$data = false;
$events = false;

$trainingTypes = TrainingType::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($trainingTypes as $trainingType) {
  $options[] = [
    'value' => $trainingType->id,
    'label' => $trainingType->name,
  ];
}

$data = [
  'options_training_types' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
