<?php

$data = false;
$events = false;

$rules = [
  'job.id' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'job.id:required' => 'No job found',
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

$inputs = Input::get('job', []);
$id = $inputs['id'] ?? 0;

Job::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'delete-job-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Job successfully deleted',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
