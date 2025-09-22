<?php

$data = false;
$events = false;

$inputs = Input::all();
$id = $inputs['id'] ?? 0;

$rules = [
  'worker_id' => 'required',
  'grievance_type_id' => 'required',
  'grievance_date' => 'required',
  'grievance_time' => 'required',
  'comments' => 'required',
];

$messages = [
  'worker_id:required' => 'Worker is required',
  'grievance_type_id:required' => 'Grievance name is required',
  'grievance_date:required' => 'Grievance date is required',
  'grievance_time:required' => 'Grievance time is required',
  'comments:required' => 'Comments is required',
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

$inputs['updated_at'] = date('Y-m-d H:i:s');

if (!$id) {
  $inputs['created_at'] = date('Y-m-d H:i:s');
  $id = WorkerGrievance::insertGetId($inputs);
} else {
  WorkerGrievance::where('id', $id)->update($inputs);
}

$events = [
  'page.init' => true,
  'modal.close' => 'add-grievance-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Grievance successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
