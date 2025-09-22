<?php

$data = false;
$events = false;

$users = User::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($users as $user) {
  $options[] = [
    'value' => $user->id,
    'label' => $user->full_name,
  ];
}

$data = [
  'options_users' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
