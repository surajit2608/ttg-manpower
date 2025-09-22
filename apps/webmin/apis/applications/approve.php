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

Worker::where('id', $workerId)->update(['status' => 'approved']);

$worker = Worker::find($workerId);

$subject = 'Congratulations, Job Application Approved';
$notificationBody = 'Congratulations, your Job Application has been approved';
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Congratulations, your Job Application has been approved.</p><p>You can login <a href="' . FULL_URL . '/login">here</a> using your username and password to manage your account.</p>';
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
Notify::toWorker($worker, $contents);

$events = [
  'page.init' => true,
  'modal.close' => 'approve-worker-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Application approved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
