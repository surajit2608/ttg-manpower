<?php

$data = false;
$events = false;

$rules = [
  'worker.title' => 'required',
  'worker.first_name' => 'required',
  'worker.last_name' => 'required',
  'worker.dob' => 'required',
  'worker.gender' => 'required',
  'worker.email' => 'required|email',
  'worker.username' => 'required',
  'worker.phone' => 'required',
  'basic.nationality_id' => 'required',
  'basic.visa_type' => 'required',
  'basic.visa_expiry' => 'required',
  'basic.address_document' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'worker.title:required' => 'Title is required',
  'worker.first_name:required' => 'First Name is required',
  'worker.last_name:required' => 'Last Name is required',
  'worker.dob:required' => 'Date of Birth is required',
  'worker.gender:required' => 'Gender is required',
  'worker.email:required' => 'Email Address is required',
  'worker.email:email' => 'Email Address is invalid',
  'worker.username:required' => 'Username is required',
  'worker.phone:required' => 'Phone is required',
  'basic.nationality_id:required' => 'Nationality is required',
  'basic.visa_expiry:required' => 'VISA Expiry Date is required',
  'basic.visa_type:required' => 'VISA Type is required',
  'basic.address_document:required' => 'Proof of Address is required',
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


$worker = Input::get('worker', []);

// add/update worker
$workerId = $worker['id'] ?? 0;
$applicationId = $worker['application_id'] ?? 0;
$firstName = $worker['first_name'] ?? null;
$middleName = $worker['middle_name'] ?? null;
$lastName = $worker['last_name'] ?? null;
$dob = $worker['dob'] ?? null;
$gender = $worker['gender'] ?? null;
$email = $worker['email'] ?? null;
$username = $worker['username'] ?? null;
$phone = $worker['phone'] ?? null;

$accountName = $firstName;
if ($middleName) {
  $accountName .= ' ' . $middleName;
}
$accountName .= ' ' . $lastName;

$worker = Worker::find($workerId);
if (!$worker) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => 'No worker found',
    ],
  ];
  goto RESPONSE;
}

$worker->application_id = $applicationId;
$worker->first_name = $firstName;
$worker->middle_name = $middleName;
$worker->last_name = $lastName;
$worker->account_name = $accountName;
$worker->dob = $dob;
$worker->gender = $gender;
$worker->email = $email;
$worker->username = $username;
$worker->phone = $phone;
$worker->updated_at = date('Y-m-d H:i:s');
$worker->save();
// add/update worker


// Save basic
$basic = Input::get('basic', []);

if (isset($basic['passport_front']) && !empty($basic['passport_front'])) {
  $passportFront = WorkerDocument::where('worker_id', $worker->id)->where('document_type_id', 1)->first();
  if (!$passportFront) {
    $passportFront = new WorkerDocument;
    $passportFront->created_at = date('Y-m-d H:i:s');
  }
  $passportFront->worker_id = $worker->id;
  $passportFront->document_type_id = 1;
  $passportFront->document = $basic['passport_front'];
  $passportFront->updated_at = date('Y-m-d H:i:s');
  $passportFront->save();
}
if (isset($basic['passport_back']) && !empty($basic['passport_back'])) {
  $passportBack = WorkerDocument::where('worker_id', $worker->id)->where('document_type_id', 2)->first();
  if (!$passportBack) {
    $passportBack = new WorkerDocument;
    $passportBack->created_at = date('Y-m-d H:i:s');
  }
  $passportBack->worker_id = $worker->id;
  $passportBack->document_type_id = 2;
  $passportBack->document = $basic['passport_back'];
  $passportBack->updated_at = date('Y-m-d H:i:s');
  $passportBack->save();
}
if (isset($basic['university_letter']) && !empty($basic['university_letter'])) {
  $universityLetter = WorkerDocument::where('worker_id', $worker->id)->where('document_type_id', 3)->first();
  if (!$universityLetter) {
    $universityLetter = new WorkerDocument;
    $universityLetter->created_at = date('Y-m-d H:i:s');
  }
  $universityLetter->worker_id = $worker->id;
  $universityLetter->document_type_id = 3;
  $universityLetter->document = $basic['university_letter'];
  $universityLetter->updated_at = date('Y-m-d H:i:s');
  $universityLetter->save();
}

if (isset($basic['license_document']) && !empty($basic['license_document'])) {
  $licenseDocument = WorkerDocument::where('worker_id', $worker->id)->where('document_type_id', 10)->first();
  if (!$licenseDocument) {
    $licenseDocument = new WorkerDocument;
    $licenseDocument->created_at = date('Y-m-d H:i:s');
  }
  $licenseDocument->worker_id = $worker->id;
  $licenseDocument->document_type_id = 10;
  $licenseDocument->document = $basic['license_document'];
  $licenseDocument->updated_at = date('Y-m-d H:i:s');
  $licenseDocument->save();
}

if (isset($basic['address_document']) && !empty($basic['address_document'])) {
  $addressDocument = WorkerDocument::where('worker_id', $worker->id)->where('document_type_id', 11)->first();
  if (!$addressDocument) {
    $addressDocument = new WorkerDocument;
    $addressDocument->created_at = date('Y-m-d H:i:s');
  }
  $addressDocument->worker_id = $worker->id;
  $addressDocument->document_type_id = 10;
  $addressDocument->document = $basic['address_document'];
  $addressDocument->updated_at = date('Y-m-d H:i:s');
  $addressDocument->save();
}

$basicId = $basic['id'] ?? 0;
$basic['updated_at'] = date('Y-m-d H:i:s');
if (!$basicId) {
  $basic['created_at'] = date('Y-m-d H:i:s');
  $basicId = WorkerBasic::insertGetId($basic);
} else {
  WorkerBasic::where('id', $basicId)->update($basic);
}

$basic = WorkerBasic::find($basicId);


// Save class
$class = Input::get('class', []);

$classId = $class['id'] ?? 0;
$class['updated_at'] = date('Y-m-d H:i:s');
if (!$classId) {
  $class['created_at'] = date('Y-m-d H:i:s');
  $classId = WorkerClass::insertGetId($class);
} else {
  WorkerClass::where('id', $classId)->update($class);
}

$class = WorkerBasic::find($classId);


$weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

// Save availability
$availability = Input::get('availability', []);

foreach ($weekdays as $weekday) {
  if (isset($availability[$weekday . '_from'])) {
    $availability[$weekday . '_from'] = date('H:i:00', strtotime($availability[$weekday . '_from']));
  }
  if (isset($availability[$weekday . '_to'])) {
    $availability[$weekday . '_to'] = date('H:i:00', strtotime($availability[$weekday . '_to']));
  }
}

$availabilityId = $availability['id'] ?? 0;
$availability['updated_at'] = date('Y-m-d H:i:s');
if (!$availabilityId) {
  $availability['created_at'] = date('Y-m-d H:i:s');
  $availabilityId = WorkerAvailability::insertGetId($availability);
} else {
  WorkerAvailability::where('id', $availabilityId)->update($availability);
}

$availability = WorkerAvailability::find($availabilityId);


// Save Term Breaks
$termbreaks = Input::get('termbreaks', []);

foreach ($termbreaks as $termbreak) {

  foreach ($weekdays as $weekday) {
    if (isset($termbreak[$weekday . '_start'])) {
      $termbreak[$weekday . '_start'] = $termbreak[$weekday . '_start'];
    }
    if (isset($termbreak[$weekday . '_end'])) {
      $termbreak[$weekday . '_end'] = $termbreak[$weekday . '_end'];
    }
  }

  if (!isset($termbreak['id'])) {
    $termbreak['worker_id'] = $worker->id;
    $termbreak['created_at'] = date('Y-m-d H:i:s');
  }
  $termbreak['updated_at'] = date('Y-m-d H:i:s');

  if (!isset($termbreak['id'])) {
    WorkerTermbreak::insert($termbreak);
  } else {
    WorkerTermbreak::where('id', $termbreak['id'])->update($termbreak);
  }
}

$termbreaks = WorkerTermbreak::whereNull('deleted_at')->where('worker_id', $worker->id)->get();


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'class' => $class,
  'basic' => $basic,
  'worker' => $worker,
  'termbreaks' => $termbreaks,
  'availability' => $availability,
  'change_log.comment' => '',
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Basic Information successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
