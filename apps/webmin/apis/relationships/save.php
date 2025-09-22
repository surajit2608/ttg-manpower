<?php

$data = false;
$events = false;

$inputs = Input::get('relationship', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'relationship.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'relationship.name:required' => 'Relationship is required',
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

$relationship = Relationship::find($id);
$checkRelationship = Relationship::where('name', $name);

if (!$relationship) {
  $checkRelationship = $checkRelationship->first();
  if ($checkRelationship) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A relationship is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $relationship = new Relationship;
  $relationship->created_at = date('Y-m-d H:i:s');
} else {
  $checkRelationship = $checkRelationship->where('id', '!=', $relationship->id)->first();
  if ($checkRelationship) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A relationship is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$relationship->name = $name;
$relationship->updated_at = date('Y-m-d H:i:s');
$relationship->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-relationship-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Relationship successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
