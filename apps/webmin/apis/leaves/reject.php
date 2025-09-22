<?php

$data = false;
$events = false;

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
$comment = Input::get('comment', null);

$leave = Leave::with('holiday', 'worker')->find($leaveId);
if (!$leave) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'No leave application found',
    ],
  ];
  goto RESPONSE;
}
$leave->comment = $comment;
$leave->status = 'rejected';
$leave->save();

$worker = $leave->worker;
$holiday = $leave->holiday;

$subject = 'Sorry, Leave Application Rejected';
$notificationBody = 'Sorry, your Leave Application for ' . $holiday->name . ' on ' . $holiday->date . ' has been rejected';
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Sorry, your Leave Application for ' . $holiday->name . ' on ' . $holiday->date . ' has been rejected.</p>';
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
$url = SITE_URL . '/leaves';
Notify::toWorker($worker, $contents, $url);

$events = [
  'page.init' => true,
  'modal.close' => 'reject-leave-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Leave application rejected',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
