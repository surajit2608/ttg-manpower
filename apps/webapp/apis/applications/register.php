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
  'confirm_password' => 'required|same:password',
  'address.address' => 'required',
  'address.city' => 'required',
  'address.post_code' => 'required',
  'address.country' => 'required',
  'basic.visa_type' => 'required',
  'basic.visa_expiry' => 'required',
];

$messages = [
  'title:required' => 'Title is required',
  'first_name:required' => 'First Name is required',
  'last_name:required' => 'Last Name is required',
  'dob:required' => 'Date of Birth is required',
  'gender:required' => 'Gender is required',
  'email:required' => 'Email Address is required',
  'email:email' => 'Email Address is not valid',
  'phone:required' => 'Phone is required',
  'username:required' => 'Username is required',
  'password:required' => 'Password is required',
  'password:min' => 'Password must be atleast 8 characters long',
  'password:regex' => 'Password must be alpha-numeric, contains atleast one special character, one capital letter and one small letter',
  'confirm_password:required' => 'Confirm Password is required',
  'confirm_password:same' => 'Confirm password does not match',
  'address.address:required' => 'House No & Street Address is required',
  'address.city:required' => 'City is required',
  'address.post_code:required' => 'Post Code is required',
  'address.country:required' => 'Country is required',
  'basic.visa_type:required' => 'VISA Type is required',
  'basic.visa_expiry:required' => 'VISA Expiry is required',
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

$applicationId = Input::get('application_id', 0);
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
$tzOffset = Input::get('tz_offset', 0);

$worker = Worker::where('email', $email)->orWhere('phone', $phone)->orWhere('username', $username)->first();
if ($worker) {
  if ($worker->email == $email) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'This email is is already registered',
      ],
    ];
  }
  if ($worker->phone == $phone) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'This phone is already reqistered',
      ],
    ];
  }
  if ($worker->username == $username) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'This username is already taken, try another one',
      ],
    ];
  }
  goto RESPONSE;
}

$accountName = $firstName;
if ($middleName) {
  $accountName .= ' ' . $middleName;
}
$accountName .= ' ' . $lastName;

// Save Worker
$worker = new Worker;
$worker->application_id = $applicationId;
$worker->title = $title;
$worker->first_name = $firstName;
$worker->middle_name = $middleName;
$worker->last_name = $lastName;
$worker->account_name = $accountName;
$worker->gender = $gender;
$worker->dob = $dob;
$worker->email = $email;
$worker->phone = $phone;
$worker->username = $username;
$worker->password = Crypto::password($password);
$worker->tz_offset = $tzOffset;
$worker->created_at = date('Y-m-d H:i:s');
$worker->updated_at = date('Y-m-d H:i:s');
$worker->status = 'active';
$worker->save();


// Save Basic
$basic = Input::get('basic', []);
$visaType = $basic['visa_type'] ?? null;
$visaExpiry = $basic['visa_expiry'] ?? null;
$passportExpiry = $basic['passport_expiry'] ?? null;
$nationalityId = $basic['nationality_id'] ?? 0;

$workerBasic = new WorkerBasic;
$workerBasic->worker_id = $worker->id;
$workerBasic->visa_type = $visaType;
$workerBasic->visa_expiry = $visaExpiry;
$workerBasic->passport_expiry = $passportExpiry;
$workerBasic->nationality_id = $nationalityId;
$workerBasic->created_at = date('Y-m-d H:i:s');
$workerBasic->updated_at = date('Y-m-d H:i:s');
$workerBasic->save();


// Save Address
$location = Input::get('address', []);
$address = $location['address'] ?? null;
$city = $location['city'] ?? null;
$postCode = $location['post_code'] ?? null;
$country = $location['country'] ?? null;

$latitude = 0;
$longitude = 0;
$fullAddress = $address . ', ' . $city . ', ' . $postCode . ', ' . $country;
$latLng = Address::getLatLon($fullAddress);
if (is_array($latLng)) {
  $latitude = $latLng[0] ?? null;
  $longitude = $latLng[1] ?? null;
}

$workerAddress = new WorkerAddress;
$workerAddress->worker_id = $worker->id;
$workerAddress->address = $address;
$workerAddress->city = $city;
$workerAddress->post_code = $postCode;
$workerAddress->country = $country;
$workerAddress->latitude = $latitude;
$workerAddress->longitude = $longitude;
$workerAddress->updated_at = date('Y-m-d H:i:s');
$workerAddress->created_at = date('Y-m-d H:i:s');
$workerAddress->save();


$application = Application::with('job')->find($applicationId);

$subject = 'Thank you for submitting Job Application';
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Thank you for submitting the job application for ' . $application->title . ' on ' . SITE_TITLE . '</p><p>You can login <a href="' . FULL_URL . '/login">here</a> using your username and password to manage your account after admin approval.</p>';
$notificationBody = 'Thank you for submitting the job application for ' . $application->title;
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
Notify::toWorker($worker, $contents);

$subjectAdmin = 'Job Application Submitted';
$emailBodyAdmin = '<p>Hi</p><p>' . $worker->account_name . ' has submitted a job application for ' . $application->title . '</p>';
$notificationBodyAdmin = $worker->account_name . ' has submitted a job application for ' . $application->title;
$contents = [
  'email' => $emailBodyAdmin,
  'subject' => $subjectAdmin,
  'notification' => $notificationBodyAdmin,
];
$url = ADMIN_URL . '/workers/application/?id=' . $worker->id . '&tab=basic';
Notify::toAdmin('job', $contents, $url);

$events = [
  'message.show' => [
    'type' => 'success',
    'text' => 'Application successfully submitted',
  ],
];

$data = [
  'worker' => []
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
