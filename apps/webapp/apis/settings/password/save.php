<?php

$data = false;
$events = false;

$rules = [
  'old' => 'required',
  'new' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
  'confirm' => 'required|same:new',
];

$messages = [
  'old:required' => 'Existing password is required',
  'new:required' => 'New password is required',
  'new:min' => 'New password must be atleast 8 characters long',
  'new:regex' => 'New password must be alpha-numeric, contains atleast one special character, one capital letter and one small letter',
  'confirm:required' => 'Confirm password is required',
  'confirm:same' => 'Confirm password does not match',
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

$id = Session::get('user_id', 0);
$oldPassword = Input::get('old', null);
$newPassword = Input::get('new', null);
$confirmPassword = Input::get('confirm', null);

$user = Worker::find($id);

if (!$user) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Please login to change password',
    ],
  ];
  goto RESPONSE;
}

if ($user->password != Crypto::password($oldPassword)) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Wrong existing password entered',
    ],
  ];
  goto RESPONSE;
}

$user->password = Crypto::password($newPassword);
$user->save();

$subject = 'Password has been changed';
$emailBody = '<p>Hi ' . $user->first_name . '</p><p>Someone has changed your account password on ' . SITE_TITLE . '</p>';
$notificationBody = 'Someone has changed your account password on ' . SITE_TITLE;
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
Notify::toWorker($user, $contents);

$data = [
  'password' => [],
];

$events = [
  'page.init' => true,
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
