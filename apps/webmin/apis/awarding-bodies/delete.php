<?php

$data = false;
$events = false;

$rules = [
  'awarding_body.id' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'awarding_body.id:required' => 'No awarding body found',
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

$inputs = Input::get('awarding_body', []);
$id = $inputs['id'] ?? 0;

AwardingBody::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'delete-awarding-body-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Awarding body successfully deleted',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
