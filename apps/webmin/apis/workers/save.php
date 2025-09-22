<?php

$data = false;
$events = false;

$rules = [
  'title' => 'required',
  'first_name' => 'required',
  'last_name' => 'required',
  'dob' => 'required',
  'gender' => 'required',
  'email' => 'required|email',
  'phone' => 'required',
  'username' => 'required',
  'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
];

$messages = [
  'title:required' => 'Title is required',
  'first_name:required' => 'First name is required',
  'last_name:required' => 'Last name is required',
  'dob:required' => 'Date of birth is required',
  'gender:required' => 'Gender is required',
  'email:required' => 'Email Address is required',
  'email:email' => 'Email Address is not valid',
  'phone:required' => 'Phone is required',
  'username:required' => 'Username is required',
  'password:required' => 'Password is required',
  'password:min' => 'Password must be atleast 8 characters long',
  'password:regex' => 'Password must be alpha-numeric, contains atleast one special character, one capital letter and one small letter',
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

$title = Input::get('title', null);
$firstName = Input::get('first_name', null);
$middleName = Input::get('middle_name', null);
$lastName = Input::get('last_name', null);
$dob = Input::get('dob', null);
$gender = Input::get('gender', null);
$email = Input::get('email', null);
$phone = Input::get('phone', null);
$username = Input::get('username', null);
$password = Input::get('password', null);

$accountName = $firstName;
if ($middleName) {
  $accountName .= $middleName;
}
$accountName .= $lastName;

$worker = new Worker;
$worker->title = $title;
$worker->first_name = $firstName;
$worker->middle_name = $middleName;
$worker->last_name = $lastName;
$worker->account_name = $accountName;
$worker->dob = $dob;
$worker->gender = $gender;
$worker->email = $email;
$worker->phone = $phone;
$worker->username = $username;
$worker->password = Crypto::password($password);
$worker->status = 'approved';
$worker->created_at = date('Y-m-d H:i:s');
$worker->updated_at = date('Y-m-d H:i:s');
$worker->save();


$workerBasic = new WorkerBasic;
$workerBasic->worker_id = $worker->id;
$workerBasic->created_at = date('Y-m-d H:i:s');
$workerBasic->updated_at = date('Y-m-d H:i:s');
$workerBasic->save();


$events = [
  'page.init' => true,
  'modal.close' => 'add-worker-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Worker successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
