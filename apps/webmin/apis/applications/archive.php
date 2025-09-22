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

Worker::where('id', $workerId)->update(['status' => 'archived']);

// $worker = Worker::find($workerId);

// $subject = 'Profile Archived';
// $notificationBody = 'Your Profile has been archived';
// $emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Your profile has been archived.</p>';
// $contents = [
//   'email' => $emailBody,
//   'subject' => $subject,
//   'notification' => $notificationBody,
// ];
// Notify::toWorker($worker, $contents);

$events = [
  'page.init' => true,
  'modal.close' => 'archive-worker-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Worker archived',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
