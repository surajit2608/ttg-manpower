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
$leave->status = 'approved';
$leave->save();

$worker = $leave->worker;
$holiday = $leave->holiday;

$subject = 'Congratulations, Leave Application Approved';
$notificationBody = 'Congratulations, your Leave Application for ' . $holiday->name . ' on ' . $holiday->date . ' is approved';
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Congratulations, your Leave Application for ' . $holiday->name . ' on ' . $holiday->date . ' is approved.</p>';
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
$url = SITE_URL . '/leaves';
Notify::toWorker($worker, $contents, $url);

$events = [
  'page.init' => true,
  'modal.close' => 'approve-leave-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Leave application approved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
