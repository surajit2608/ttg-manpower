<?php

$data = false;
$events = false;

$grievanceTypes = GrievanceType::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($grievanceTypes as $grievanceType) {
  $options[] = [
    'value' => $grievanceType->id,
    'label' => $grievanceType->name,
  ];
}

$data = [
  'options_grievance_types' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
