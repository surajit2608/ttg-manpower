<?php

$data = false;
$events = false;

$rules = [
  'grievance_type.id' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'grievance_type.id:required' => 'No grievance type found',
  'change_log.comment:required' => 'Reason for Delete is required',
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

$inputs = Input::get('grievance_type', []);
$id = $inputs['id'] ?? 0;

GrievanceType::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'delete-grievance-type-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Grievance type successfully deleted',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
