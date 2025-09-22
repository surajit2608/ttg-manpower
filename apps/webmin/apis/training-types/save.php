<?php

$data = false;
$events = false;

$inputs = Input::get('training_type', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'training_type.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'training_type.name:required' => 'Training type is required',
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

$trainingType = TrainingType::find($id);
$checkTrainingType = TrainingType::where('name', $name);

if (!$trainingType) {
  $checkTrainingType = $checkTrainingType->first();
  if ($checkTrainingType) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A training type is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $trainingType = new TrainingType;
  $trainingType->created_at = date('Y-m-d H:i:s');
} else {
  $checkTrainingType = $checkTrainingType->where('id', '!=', $trainingType->id)->first();
  if ($checkTrainingType) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A training type is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$trainingType->name = $name;
$trainingType->updated_at = date('Y-m-d H:i:s');
$trainingType->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-training-type-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Training type successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
