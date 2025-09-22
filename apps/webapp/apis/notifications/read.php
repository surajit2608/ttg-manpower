<?php

$data = false;
$events = false;

$rules = [];

$messages = [];

$errors = Input::validate($rules, $messages);
if ($errors) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => $errors[0],
    ],
  ];
  goto RESPONSE;
}

$id = Input::get('id', 0);
$userId = Session::get('user_id', 0);

if ($id) {
  Notification::where('id', $id)->update(['status' => 'read']);
} else {
  Notification::where('receiver_id', $userId)->where('receiver_type', 'worker')->update(['status' => 'read']);
}

$events = [
  'page.init' => true
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
