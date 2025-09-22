<?php

$data = false;
$events = false;

$inputs = Input::get('nationality', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'nationality.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'nationality.name:required' => 'Nationality is required',
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

$nationality = Nationality::find($id);
$checkNationality = Nationality::where('name', $name);

if (!$nationality) {
  $checkNationality = $checkNationality->first();
  if ($checkNationality) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A nationality is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $nationality = new Nationality;
  $nationality->created_at = date('Y-m-d H:i:s');
} else {
  $checkNationality = $checkNationality->where('id', '!=', $nationality->id)->first();
  if ($checkNationality) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A nationality is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$nationality->name = $name;
$nationality->updated_at = date('Y-m-d H:i:s');
$nationality->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-nationality-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Nationality successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
