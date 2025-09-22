<?php

$data = false;
$events = false;

$rules = [];

$inputs = Input::all();

if (!$inputs['trainings'][0]['no_training']) {
  $rules = [
    'trainings.*.qualification' => 'required',
    'trainings.*.award_date' => 'required',
    'trainings.*.institute' => 'required',
    'trainings.*.course_length' => 'required',
    'trainings.*.institute_contact_name' => 'required',
    'trainings.*.institute_contact_phone' => 'required',
    'trainings.*.institute_contact_email' => 'required',
    'trainings.*.institute_address' => 'required',
  ];
}

$rules['change_log.comment'] = 'required';

$messages = [
  'trainings.*.qualification:required' => 'Qualification is required',
  'trainings.*.award_date:required' => 'Award Date is required',
  'trainings.*.institute:required' => 'Institute is required',
  'trainings.*.course_length:required' => 'Course Length is required',
  'trainings.*.institute_contact_name:required' => 'Institute Contact Name is required',
  'trainings.*.institute_contact_phone:required' => 'Institute Contact Phone is required',
  'trainings.*.institute_contact_email:required' => 'Institute Contact Email is required',
  'trainings.*.institute_address:required' => 'Institute Address is required',
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
$trainings = $inputs['trainings'] ?? [];
foreach ($trainings as $input) {
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


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'trainings' => $trainings,
  'change_log.comment' => '',
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
