<?php

$data = false;
$events = false;

$reference = false;
$inputs = Input::all();

$rules = [];

if (!$inputs['employments'][0]['no_employment']) {
  $rules = [
    'employments.*.employment_position' => 'required',
    'employments.*.leaving_reason' => 'required',
    'employments.*.reference_name' => 'required',
    'employments.*.reference_address' => 'required',
    'employments.*.reference_phone' => 'required',
    'employments.*.reference_email' => 'required',
  ];
  if (Input::has('employment')) {
    $rules['employment.reference_name'] = 'required';
    $rules['employment.reference_phone'] = 'required';
    $rules['employment.reference_email'] = 'required';
    $rules['employment.reference_profession'] = 'required';
  }
}

$rules['change_log.comment'] = 'required';

$messages = [
  'employments.*.employment_position:required' => 'Position Held/Unemployed and Claiming Benefit/Travelling/Study is required',
  'employments.*.leaving_reason:required' => 'Reason for Leaving/Status is required',
  'employments.*.reference_name:required' => 'Company/Personal Reference Name is required',
  'employments.*.reference_address:required' => 'Company/Personal Reference Address is required',
  'employments.*.reference_phone:required' => 'Company/Personal Reference Phone is required',
  'employments.*.reference_email:required' => 'Company/Personal Reference Email Address is required',
  'employment.reference_name:required' => 'Gap Reference Name is required',
  'employment.reference_phone:required' => 'Gap Reference Phone is required',
  'employment.reference_email:required' => 'Gap Reference Email is required',
  'employment.reference_profession:required' => 'Gap Reference Profession is required',
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

$ids = [];
$employments = $inputs['employments'] ?? [];
foreach ($employments as $input) {
  $id = $input['id'] ?? 0;

  if (isset($input['experience_letter']) && !empty($input['experience_letter'])) {
    $experienceLetter = WorkerDocument::where('worker_id', $input['worker_id'])->where('document_type_id', 8)->first();
    if (!$experienceLetter) {
      $experienceLetter = new WorkerDocument;
      $experienceLetter->created_at = date('Y-m-d H:i:s');
    }
    $experienceLetter->worker_id  = $input['worker_id'];
    $experienceLetter->document_type_id = 8;
    $experienceLetter->document = $input['experience_letter'];
    $experienceLetter->updated_at = date('Y-m-d H:i:s');
    $experienceLetter->save();
  }

  $input['updated_at'] = date('Y-m-d H:i:s');
  if (!$id) {
    $input['created_at'] = date('Y-m-d H:i:s');
    $id = WorkerEmployment::insertGetId($input);
  } else {
    WorkerEmployment::where('id', $id)->update($input);
  }
  $ids[] = $id;
}

$employments = WorkerEmployment::whereIn('id', $ids)->get();

if (Input::has('employment')) {
  $employment = $inputs['employment'] ?? [];
  $referenceId = $employment['id'] ?? 0;
  $workerId = $employments[0]['worker_id'] ?? 0;

  $reference = WorkerEmploymentReference::find($referenceId);
  if (!$reference) {
    $reference = new WorkerEmploymentReference;
    $reference->created_at = date('Y-m-d H:i:s');
  }
  $reference->worker_id = $workerId;
  $reference->updated_at = date('Y-m-d H:i:s');
  $reference->reference_name = $employment['reference_name'];
  $reference->reference_phone = $employment['reference_phone'];
  $reference->reference_email = $employment['reference_email'];
  $reference->reference_profession = $employment['reference_profession'];
  $reference->save();
}


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'employment' => $reference,
  'employments' => $employments,
  'change_log.comment' => '',
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Employment history successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
