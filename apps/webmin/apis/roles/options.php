<?php

$data = false;
$events = false;

$roles = Role::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($roles as $role) {
  $options[] = [
    'value' => $role->id,
    'label' => $role->name,
  ];
}

$data = [
  'options_roles' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
