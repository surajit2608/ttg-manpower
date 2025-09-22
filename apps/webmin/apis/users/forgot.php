<?php

$data = false;
$events = false;

$rules = [
  'username' => 'required',
  'new' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
  'confirm' => 'required|same:new',
];

$messages = [
  'username:required' => 'Username is required',
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

$username = Input::get('username', null);
$newPassword = Input::get('new', null);
$newPassword = Crypto::password($newPassword);

if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
  $user = User::where('email', $username);
} else {
  $user = User::where('username', $username);
}
$user = $user->first();

if (!$user) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Invalid username entered',
    ],
  ];
  goto RESPONSE;
}

$userId = Crypto::encrypt($user->id);
$expireTime = Crypto::encrypt(date('Y-m-d H:i:s', strtotime('now +10 minutes')));

$token = $userId . $expireTime . $newPassword;
$newTk = Crypto::hash($token, 8);

$resetUrl = FULL_URL . "/admin/password/reset/?token=$newPassword&expire=$expireTime&auth=$userId&tk=$newTk";

$subject = 'Reset Your Password';
$message = '<p>Hi ' . $user->first_name . '</p><p>This is your password reset request of ' . SITE_TITLE . ' account. Please click the below link to reset the password.</p><p><a href="' . $resetUrl . '">Reset Your Password</a></p>';
Notify::email($user->email, $subject, $message);

$events = [
  'message.show' => [
    'type' => 'success',
    'text' => 'A link has been sent to your email address to reset the password',
  ],
];

$data = [
  'password' => [],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
