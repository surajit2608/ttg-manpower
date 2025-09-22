<?php

$data = false;
$events = false;

$inputs = Input::get('holiday', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'holiday.name' => 'required',
  'holiday.date' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'holiday.name:required' => 'Holiday name is required',
  'holiday.date:required' => 'Holiday date is required',
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
$date = $inputs['date'] ?? 0;

$holiday = Holiday::find($id);
$checkHoliday = Holiday::where('date', $date);

if (!$holiday) {
  $checkHoliday = $checkHoliday->first();
  if ($checkHoliday) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A holiday is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $holiday = new Holiday;
  $holiday->created_at = date('Y-m-d H:i:s');
} else {
  $checkHoliday = $checkHoliday->where('id', '!=', $holiday->id)->first();
  if ($checkHoliday) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A holiday is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$holiday->name = $name;
$holiday->date = $date;
$holiday->updated_at = date('Y-m-d H:i:s');
$holiday->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-holiday-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Holiday successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
