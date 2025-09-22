<?php

$data = false;
$events = false;

$awardingBodies = AwardingBody::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($awardingBodies as $awardingBody) {
  $options[] = [
    'value' => $awardingBody->id,
    'label' => $awardingBody->name,
  ];
}

$data = [
  'options_awarding_bodies' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
