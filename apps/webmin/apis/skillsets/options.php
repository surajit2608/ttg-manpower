<?php

$data = false;
$events = false;

$skillsets = Skillset::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($skillsets as $skillset) {
  $options[] = [
    'value' => $skillset->id,
    'label' => $skillset->name,
  ];
}

$data = [
  'options_skillsets' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
