<?php

$data = false;
$events = false;

$rules = [
  'name' => 'required',
  'wage' => 'required',
];

$messages = [
  'name:required' => 'Name is required',
  'wage:required' => 'Hourly wage is required',
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

$id = Input::get('id', 0);
$name = Input::get('name', null);
$wage = Input::get('wage', 0);

$skillset = Skillset::find($id);
$checkSkillset = Skillset::where('name', $name);

if (!$skillset) {
  $checkSkillset = $checkSkillset->first();
  if ($checkSkillset) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A skillset is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $skillset = new Skillset;
  $skillset->created_at = date('Y-m-d H:i:s');
} else {
  $checkSkillset = $checkSkillset->where('id', '!=', $skillset->id)->first();
  if ($checkSkillset) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A skillset is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$skillset->name = $name;
$skillset->wage = $wage;
$skillset->updated_at = date('Y-m-d H:i:s');
$skillset->save();

$events = [
  'page.init' => true,
  'modal.close' => 'add-skillset-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Skillset successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
