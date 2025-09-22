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
  'role_id' => 'required',
];

$messages = [
  'first_name:required' => 'First name is required',
  'last_name:required' => 'Last name is required',
  'image:required' => 'User image is required',
  'email:required' => 'Email Address is required',
  'email:email' => 'Email Address is not valid',
  'username:required' => 'Username is required',
  'phone:required' => 'Phone is required',
  'role_id:required' => 'Role is required',
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
$roleId = Input::get('role_id', []);

$user = User::find($id);

if (!$user) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'Please login to update profile',
    ],
  ];
  goto RESPONSE;
}

$user->first_name = $firstname;
$user->last_name = $lastname;
$user->full_name = $fullname;
$user->image = $image;
$user->email = $email;
$user->username = $username;
$user->phone = $phone;
$user->role_id = $roleId;
$user->updated_at = date('Y-m-d H:i:s');
$user->save();

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
