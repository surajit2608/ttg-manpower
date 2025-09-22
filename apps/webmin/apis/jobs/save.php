<?php

$data = false;
$events = false;

$inputs = Input::get('job', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'job.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'job.name:required' => 'Job is required',
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

$name = $inputs['name'] ?? null;

$job = Job::find($id);
$checkJob = Job::where('name', $name);

if (!$job) {
  $checkJob = $checkJob->first();
  if ($checkJob) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A job is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $job = new Job;
  $job->created_at = date('Y-m-d H:i:s');
} else {
  $checkJob = $checkJob->where('id', '!=', $job->id)->first();
  if ($checkJob) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A job is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$job->name = $name;
$job->updated_at = date('Y-m-d H:i:s');
$job->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-job-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Job successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
