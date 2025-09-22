<?php

$data = false;
$events = false;

$inputs = Input::get('user', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'user.first_name' => 'required',
  'user.last_name' => 'required',
  'user.image' => 'required',
  'user.email' => 'required|email',
  'user.username' => 'required',
  'user.phone' => 'required',
  'user.role_id' => 'required',
];

if (!$id) {
  $rules['user.password'] = 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
}
if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'user.first_name:required' => 'First name is required',
  'user.last_name:required' => 'Last name is required',
  'user.image:required' => 'User image is required',
  'user.email:required' => 'Email Address is required',
  'user.email:email' => 'Email Address is not valid',
  'user.username:required' => 'Username is required',
  'user.password:required' => 'Password is required',
  'user.password:min' => 'Password must be atleast 8 characters long',
  'user.password:regex' => 'Password must be alpha-numeric, contains atleast one special character, one capital letter and one small letter',
  'user.phone:required' => 'Phone is required',
  'user.role_id:required' => 'Role is required',
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

$firstname = $inputs['first_name'] ?? null;
$lastname = $inputs['last_name'] ?? null;
$fullname = $firstname . ' ' . $lastname;
$image = $inputs['image'] ?? null;
$email = $inputs['email'] ?? null;
$username = $inputs['username'] ?? null;
$password = $inputs['password'] ?? null;
$phone = $inputs['phone'] ?? null;
$roleId = $inputs['role_id'] ?? [];

$user = User::find($id);
$checkUser = User::where(function ($query) use (&$email, &$username, &$phone) {
  $query->orWhere('email', $email);
  $query->orWhere('username', $username);
  $query->orWhere('phone', $phone);
});

if (!$user) {
  $checkUser = $checkUser->first();
  if ($checkUser) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A user is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $user = new User;
  $user->password = Crypto::password($password);
  $user->created_at = date('Y-m-d H:i:s');
} else {
  $checkUser = $checkUser->where('id', '!=', $user->id)->first();
  if ($checkUser) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A user is already exists',
      ],
    ];
    goto RESPONSE;
  }
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

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-user-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'User successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
