<?php

$data = false;
$events = false;

$inputs = Input::get('awarding_body', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'awarding_body.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'awarding_body.name:required' => 'Awarding body is required',
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

$awarding = AwardingBody::find($id);
$checkAwarding = AwardingBody::where('name', $name);

if (!$awarding) {
  $checkAwarding = $checkAwarding->first();
  if ($checkAwarding) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'An awarding body is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $awarding = new AwardingBody;
  $awarding->created_at = date('Y-m-d H:i:s');
} else {
  $checkAwarding = $checkAwarding->where('id', '!=', $awarding->id)->first();
  if ($checkAwarding) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'An awarding body is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$awarding->name = $name;
$awarding->updated_at = date('Y-m-d H:i:s');
$awarding->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-awarding-body-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Awarding body successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
