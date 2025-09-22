<?php

$data = false;
$events = false;

$rules = [
  'first_name' => 'required',
  'last_name' => 'required',
  'image' => 'required',
  'email' => 'required|email',
  'username' => 'required',
  'phone' => 'required',
];

$messages = [
  'first_name:required' => 'First name is required',
  'last_name:required' => 'Last name is required',
  'image:required' => 'User image is required',
  'email:required' => 'Email Address is required',
  'email:email' => 'Email Address is not valid',
  'username:required' => 'Username is required',
  'phone:required' => 'Phone is required',
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

$id = Session::get('admin_id', 0);
$firstname = Input::get('first_name', null);
$lastname = Input::get('last_name', null);
$fullname = $firstname . ' ' . $lastname;
$image = Input::get('image', null);
$email = Input::get('email', null);
$username = Input::get('username', null);
$password = Input::get('password', null);
$phone = Input::get('phone', null);

$worker = Worker::find($id);

if (!$worker) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Please login to update profile',
    ],
  ];
  goto RESPONSE;
}

$worker->first_name = $firstname;
$worker->last_name = $lastname;
$worker->account_name = $fullname;
$worker->image = $image;
$worker->email = $email;
$worker->username = $username;
$worker->phone = $phone;
$worker->updated_at = date('Y-m-d H:i:s');
$worker->save();

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Profile info successfully updated',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
