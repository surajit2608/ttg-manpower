<?php

$data = false;
$events = false;

$rules = [
  'username' => 'required',
  'password' => 'required',
];

$messages = [
  'username:required' => 'Username is required',
  'password:required' => 'Password is required',
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

$tzOffset = Input::get('tz_offset', 0);
$username = Input::get('username', null);
$password = Input::get('password', null);
$rememberMe = Input::get('rememberme', false);

if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
  $user = User::where('email', $username);
} else {
  $user = User::where('username', $username);
}

$user = $user->whereNull('deleted_at')->first();

if (!$user) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Invalid credentials entered',
    ],
  ];
  goto RESPONSE;
}

if (Crypto::password($password) != $user->password) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Invalid credentials entered',
    ],
  ];
  goto RESPONSE;
}

$user->tz_offset = $tzOffset;
$user->last_loggedin = date('Y-m-d H:i:s');
$user->save();

if ($rememberMe) {
  setcookie('_mpwr_usr_pass', $password, time() + (10 * 365 * 24 * 60 * 60), '/');
  setcookie('_mpwr_usr_name', $username, time() + (10 * 365 * 24 * 60 * 60), '/');
} else {
  if (isset($_COOKIE['_mpwr_usr_name'])) {
    setcookie('_mpwr_usr_name', '', time() - (60 * 60), '/');
  }
  if (isset($_COOKIE['_mpwr_usr_pass'])) {
    setcookie('_mpwr_usr_pass', '', time() - (60 * 60), '/');
  }
}

Session::set('admin_id', $user->id);

$data = [
  'user' => $user,
];

$events = [
  'page.redirect' => ADMIN_URL . '/dashboard',
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
