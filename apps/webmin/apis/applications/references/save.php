<?php

$data = false;
$events = false;

$rules = [
  'references.0.referee_name' => 'required',
  'references.0.referee_email' => 'required',
  'references.0.referee_phone' => 'required',
  'references.0.referee_profession' => 'required',
  'references.0.referee_relationship_id' => 'required',
  'references.0.know_last_5years' => 'required',
  'references.0.referee_address' => 'required',

  'references.1.referee_name' => 'required',
  'references.1.referee_email' => 'required',
  'references.1.referee_phone' => 'required',
  'references.1.referee_profession' => 'required',
  'references.1.referee_relationship_id' => 'required',
  'references.1.know_last_5years' => 'required',
  'references.1.referee_address' => 'required',

  'references.*.referee_name' => 'required',
  'references.*.referee_email' => 'required',
  'references.*.referee_phone' => 'required',
  'references.*.referee_profession' => 'required',
  'references.*.referee_relationship_id' => 'required',
  'references.*.know_last_5years' => 'required',
  'references.*.referee_address' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'references.*.referee_name:required' => 'Referee Name is required',
  'references.*.referee_email:required' => 'Referee Email is required',
  'references.*.referee_phone:required' => 'Referee Phone is required',
  'references.*.referee_profession:required' => 'Referee Profession is required',
  'references.*.referee_relationship_id:required' => 'Referee Relationship is required',
  'references.*.know_last_5years:required' => 'Do this person know you for last 5 years is required',
  'references.*.referee_address:required' => 'Referee Address is required',
  'change_log.comment:required' => 'Reason for Change is required',
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
$references = $inputs['references'] ?? [];
foreach ($references as $input) {
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


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'references' => $references,
  'change_log.comment' => '',
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
