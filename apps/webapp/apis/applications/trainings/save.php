<?php

$data = false;
$events = false;

$inputs = Input::all();

$rules = [];

if (!$inputs[0]['no_training']) {
  $rules = [
    '*.qualification' => 'required',
    '*.award_date' => 'required',
    '*.institute' => 'required',
    '*.course_length' => 'required',
    '*.institute_contact_name' => 'required',
    '*.institute_contact_phone' => 'required',
    '*.institute_contact_email' => 'required',
    '*.institute_address' => 'required',
  ];
}

$messages = [
  '*.qualification:required' => 'Qualification is required',
  '*.award_date:required' => 'Award Date is required',
  '*.institute:required' => 'Institute is required',
  '*.course_length:required' => 'Course Length is required',
  '*.institute_contact_name:required' => 'Institute Contact Name is required',
  '*.institute_contact_phone:required' => 'Institute Contact Phone is required',
  '*.institute_contact_email:required' => 'Institute Contact Email is required',
  '*.institute_address:required' => 'Institute Address is required',
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

foreach ($inputs as $input) {
  $id = $input['id'] ?? 0;

  $input['updated_at'] = date('Y-m-d H:i:s');
  if (!$id) {
    $input['created_at'] = date('Y-m-d H:i:s');
    $id = WorkerTraining::insertGetId($input);
  } else {
    WorkerTraining::where('id', $id)->update($input);
  }
  $ids[] = $id;
}

$trainings = WorkerTraining::whereIn('id', $ids)->get();

$data = [
  'trainings' => $trainings,
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Training & education successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
