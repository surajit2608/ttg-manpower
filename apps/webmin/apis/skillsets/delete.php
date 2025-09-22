<?php

$data = false;
$events = false;

$rules = [
  'id' => 'required',
];

$messages = [
  'id:required' => 'No skillset found',
];

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

Skillset::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

$events = [
  'page.init' => true,
  'modal.close' => 'delete-skillset-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Skillset successfully deleted',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
