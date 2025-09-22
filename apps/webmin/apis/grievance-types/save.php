<?php

$data = false;
$events = false;

$inputs = Input::get('grievance_type', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'grievance_type.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'grievance_type.name:required' => 'Grievance type is required',
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

$grievanceType = GrievanceType::find($id);
$checkGrievanceType = GrievanceType::where('name', $name);

if (!$grievanceType) {
  $checkGrievanceType = $checkGrievanceType->first();
  if ($checkGrievanceType) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A grievance type is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $grievanceType = new GrievanceType;
  $grievanceType->created_at = date('Y-m-d H:i:s');
} else {
  $checkGrievanceType = $checkGrievanceType->where('id', '!=', $grievanceType->id)->first();
  if ($checkGrievanceType) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A grievance type is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$grievanceType->name = $name;
$grievanceType->updated_at = date('Y-m-d H:i:s');
$grievanceType->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-grievance-type-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Grievance type successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
