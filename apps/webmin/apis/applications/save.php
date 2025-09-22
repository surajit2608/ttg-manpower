<?php

$data = false;
$events = false;

$inputs = Input::get('application', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'application.title' => 'required',
  'application.slug' => 'required|regex:/^[\w-]+$/',
  'application.job_id' => 'required',
  'application.client_id' => 'required',
  'application.address' => 'required',
  'application.city' => 'required',
  'application.post_code' => 'required',
  'application.country' => 'required',
  'application.hourly_salary' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'application.title:required' => 'Application Title is required',
  'application.slug:required' => 'Application URL is required',
  'application.slug:regex' => 'Invalid URL, only hyphen (-) & underscore (_) are allowed',
  'application.job_id:required' => 'Job selection is required',
  'application.client_id:required' => 'Client selection is required',
  'application.address:required' => 'Street Address is required',
  'application.city:required' => 'City is required',
  'application.post_code:required' => 'Post Code is required',
  'application.country:required' => 'Country is required',
  'application.hourly_salary:required' => 'Hourly Salary is required',
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

$title = $inputs['title'] ?? null;
$slug = $inputs['slug'] ?? null;
$jobId = $inputs['job_id'] ?? 0;
$clientId = $inputs['client_id'] ?? 0;
$address = $inputs['address'] ?? null;
$city = $inputs['city'] ?? null;
$postCode = $inputs['post_code'] ?? null;
$country = $inputs['country'] ?? null;
$hourlySalary = $inputs['hourly_salary'] ?? 0;

$latitude = null;
$longitude = null;
$fullAddress = $address . ', ' . $city . ', ' . $postCode . ', ' . $country;
$latLng = Address::getLatLon($fullAddress);
if (is_array($latLng) && count($latLng)) {
  $latitude = $latLng[0];
  $longitude = $latLng[1];
}

$checkApplicationSlug = Application::where('slug', $slug);
$checkApplicationJobClient = Application::where('job_id', $jobId)->where('client_id', $clientId);

if (!$id) {
  $checkApplicationSlug = $checkApplicationSlug->first();
  if ($checkApplicationSlug) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'An application is already exists with same url',
      ],
    ];
    goto RESPONSE;
  }

  $checkApplicationJobClient = $checkApplicationJobClient->first();
  if ($checkApplicationJobClient) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'An application is already exists with same job & client',
      ],
    ];
    goto RESPONSE;
  }

  $application = new Application;
  $application->created_at = date('Y-m-d H:i:s');
} else {
  $checkApplicationSlug = $checkApplicationSlug->where('id', '!=', $id)->first();
  if ($checkApplicationSlug) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'An application is already exists with same url',
      ],
    ];
    goto RESPONSE;
  }

  $checkApplicationJobClient = $checkApplicationJobClient->where('id', '!=', $id)->first();
  if ($checkApplicationJobClient) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'An application is already exists with same job & client',
      ],
    ];
    goto RESPONSE;
  }

  $application = Application::find($id);
}

$application->title = $title;
$application->slug = $slug;
$application->job_id = $jobId;
$application->client_id = $clientId;
$application->address = $address;
$application->city = $city;
$application->post_code = $postCode;
$application->country = $country;
$application->latitude = $latitude;
$application->longitude = $longitude;
$application->hourly_salary = $hourlySalary;
$application->updated_at = date('Y-m-d H:i:s');
$application->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-application-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Application successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
