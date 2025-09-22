<?php

$data = false;
$events = false;

$clients = Client::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($clients as $client) {
  $options[] = [
    'value' => $client->id,
    'label' => $client->business_name,
  ];
}

$data = [
  'options_clients' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
