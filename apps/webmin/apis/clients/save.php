<?php

$data = false;
$events = false;

$inputs = Input::get('client', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'client.business_name' => 'required',
  'client.contact_person' => 'required',
  'client.email' => 'required|email',
  'client.phone' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'client.business_name:required' => 'Business name is required',
  'client.contact_person:required' => 'Contact person is required',
  'client.email:required' => 'Email Address is required',
  'client.email:email' => 'Email Address is not valid',
  'client.phone:required' => 'Phone is required',
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

$businessName = $inputs['business_name'] ?? null;
$contactPerson = $inputs['contact_person'] ?? null;
$email = $inputs['email'] ?? null;
$phone = $inputs['phone'] ?? null;
$contractStart = $inputs['contract_start'] ?? null;
$contractEnd = $inputs['contract_end'] ?? null;
$weekStartDay = $inputs['week_start_day'] ?? null;
$weekEndDay = $inputs['week_end_day'] ?? null;

$client = Client::find($id);
$checkClient = Client::where(function ($query) use (&$email, &$phone) {
  $query->orWhere('email', $email);
  $query->orWhere('phone', $phone);
});

if (!$client) {
  $checkClient = $checkClient->first();
  if ($checkClient) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A client is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $client = new Client;
  $client->created_at = date('Y-m-d H:i:s');
} else {
  $checkClient = $checkClient->where('id', '!=', $client->id)->first();
  if ($checkClient) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A client is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$client->business_name = $businessName;
$client->contact_person = $contactPerson;
$client->email = $email;
$client->phone = $phone;
$client->contract_start = $contractStart;
$client->contract_end = $contractEnd;
$client->week_start_day = $weekStartDay;
$client->week_end_day = $weekEndDay;
$client->updated_at = date('Y-m-d H:i:s');
$client->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-client-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Client successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
