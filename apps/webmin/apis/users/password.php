<?php

$data = false;
$events = false;

$rules = [
  'user.id' => 'required',
  'user.newpassword' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
  'change_log.comment' => 'required',
];

$messages = [
  'user.id:required' => 'No user found',
  'user.newpassword:required' => 'Password is required',
  'user.newpassword:min' => 'Password must be atleast 8 characters long',
  'user.newpassword:regex' => 'Password must be alpha-numeric, contains atleast one special character, one capital letter and one small letter',
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

$inputs = Input::get('user', []);

$id = $inputs['id'] ?? 0;
$password = $inputs['newpassword'] ?? null;

$user = User::find($id);
$user->password = Crypto::password($password);
$user->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'password-user-modal',
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
