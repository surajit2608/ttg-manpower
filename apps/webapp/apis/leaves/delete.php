<?php

$data = false;
$events = false;

$userId = Session::get('user_id', 0);

$rules = [
  'id' => 'required',
];

$messages = [
  'id:required' => 'No leave application found',
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

$leaveId = Input::get('id', 0);

$leave = Leave::find($leaveId);
if ($leave->status != 'pending') {
  $events = [
    'modal.close' => 'delete-leave-modal',
    'message.show' => [
      'type' => 'error',
      'text' => 'Unable to delete already '.$leave->status.' leave applications',
    ],
  ];
  goto RESPONSE;
}

Leave::where('id', $leaveId)->where('worker_id', $userId)->update(['deleted_at' => date('Y-m-d H:i:s')]);

$events = [
  'page.init' => true,
  'modal.close' => 'delete-leave-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Leave application deleted',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
