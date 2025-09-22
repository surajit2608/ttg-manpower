<?php

$data = false;
$events = false;

$rules = [
  'company.logo' => 'required',
  'company.name' => 'required',
  'company.address' => 'required',
  'company.city' => 'required',
  'company.postal' => 'required',
  'company.phone' => 'required',
  'company.email' => 'required|email',
  'company.user_id' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'company.logo:required' => 'Logo is required',
  'company.name:required' => 'Name is required',
  'company.address:required' => 'Address is required',
  'company.city:required' => 'City is required',
  'company.postal:required' => 'Postal Code is required',
  'company.phone:required' => 'Phone is required',
  'company.email:required' => 'Email Address is required',
  'company.email:email' => 'Email Address is not valid',
  'company.user_id:required' => 'Contact Person is required',
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

$inputs = Input::get('company', []);

$id = $inputs['id'] ?? 0;
$logo = $inputs['logo'] ?? null;
$name = $inputs['name'] ?? null;
$address = $inputs['address'] ?? null;
$city = $inputs['city'] ?? null;
$postal = $inputs['postal'] ?? null;
$phone = $inputs['phone'] ?? null;
$fax = $inputs['fax'] ?? null;
$email = $inputs['email'] ?? null;
$website = $inputs['website'] ?? null;
$userid = $inputs['user_id'] ?? 0;

$company = Company::find($id);

if (!$company) {
  $company = new Company;
  $company->created_at = date('Y-m-d H:i:s');
}

$company->logo = $logo;
$company->name = $name;
$company->address = $address;
$company->city = $city;
$company->postal = $postal;
$company->phone = $phone;
$company->fax = $fax;
$company->email = $email;
$company->website = $website;
$company->user_id = $userid;
$company->updated_at = date('Y-m-d H:i:s');
$company->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$data = [
  'change_log.comment' => '',
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => ' Company Information successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
