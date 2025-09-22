<?php

$data = false;
$events = false;

$rules = [
  '*.referee_name' => 'required',
  '*.referee_email' => 'required',
  '*.referee_phone' => 'required',
  '*.referee_profession' => 'required',
  '*.referee_relationship_id' => 'required',
  '*.know_last_5years' => 'required',
  '*.referee_address' => 'required',
];

$messages = [
  '*.referee_name:required' => 'Referee Name is required',
  '*.referee_email:required' => 'Referee Email is required',
  '*.referee_phone:required' => 'Referee Phone is required',
  '*.referee_profession:required' => 'Referee Profession is required',
  '*.referee_relationship_id:required' => 'Referee Relationship is required',
  '*.know_last_5years:required' => 'Do this person know you for last 5 years is required',
  '*.referee_address:required' => 'Referee Address is required',
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

$ids = [];
$inputs = Input::all();

foreach ($inputs as $input) {
  $id = $input['id'] ?? 0;

  $input['updated_at'] = date('Y-m-d H:i:s');
  if (!$id) {
    $input['created_at'] = date('Y-m-d H:i:s');
    $id = WorkerReference::insertGetId($input);
  } else {
    WorkerReference::where('id', $id)->update($input);
  }
  $ids[] = $id;
}

$references = WorkerReference::whereIn('id', $ids)->get();

$data = [
  'references' => $references,
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'References successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
