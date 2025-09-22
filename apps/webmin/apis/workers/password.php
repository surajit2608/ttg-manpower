<?php

$data = false;
$events = false;

$rules = [
  'worker.id' => 'required',
  'worker.newpassword' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
  'change_log.comment' => 'required',
];

$messages = [
  'worker.id:required' => 'No worker found',
  'worker.newpassword:required' => 'Password is required',
  'worker.newpassword:min' => 'Password must be atleast 8 characters long',
  'worker.newpassword:regex' => 'Password must be alpha-numeric, contains atleast one special character, one capital letter and one small letter',
  'change_log.comment:required' => 'Reason for Change is required',
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

$inputs = Input::get('worker', []);

$id = $inputs['id'] ?? 0;
$password = $inputs['newpassword'] ?? null;

$worker = Worker::find($id);
$worker->password = Crypto::password($password);
$worker->save();

$subject = 'Password Changed';
$notificationBody = 'Admin has changed your login password';
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Admin has changed your login password.</p><p>Below is your new login password:</p><p>Password: ' . $password . '</p>';
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
Notify::toWorker($worker, $contents);

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'password-worker-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Password successfully changed',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
