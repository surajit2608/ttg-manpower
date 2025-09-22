<?php

$data = false;
$events = false;

$rules = [
  'worker_id' => 'required',
];

$messages = [
  'worker_id:required' => 'No worker/application found',
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

$workerId = Input::get('worker_id', 0);

Worker::where('id', $workerId)->update(['status' => 'rejected']);

$subject = 'Sorry, Job Application Rejected';
$notificationBody = 'Sorry, your Job Application has been rejected';
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Sorry, your Leave Application has been rejected.</p>';
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
Notify::toWorker($worker, $contents);

$events = [
  'page.init' => true,
  'modal.close' => 'reject-worker-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Application rejected',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
