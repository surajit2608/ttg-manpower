<?php

$data = false;
$events = false;

$rules = [
  'policy.agreement1' => 'accepted',
  'policy.agreement2' => 'accepted',
  'policy.agreement3' => 'accepted',
  'change_log.comment' => 'required',
];

$messages = [
  'policy.agreement1:accepted' => "Please agree to work in excess of 48 hours on average per week and will give three months' notice in writing to the Head of Human Resources if I no longer wish to work this number of hours",
  'policy.agreement2:accepted' => "Please agree to work in excess of 48 hours on average per week and will inform the Human Resources Manager if there is any deviation in the number of hours a week I work",
  'policy.agreement3:accepted' => "Please agree to like Opt out of the pension scheme",
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

$inputs = Input::get('policy', []);

$id = $inputs['id'] ?? 0;

$inputs['updated_at'] = date('Y-m-d H:i:s');
if (!$id) {
  $inputs['created_at'] = date('Y-m-d H:i:s');
  $id = WorkerPolicy::insertGetId($inputs);
} else {
  WorkerPolicy::where('id', $id)->update($inputs);
}

$policy = WorkerPolicy::find($id);


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'policy' => $policy,
  'change_log.comment' => '',
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Policy and Declaration successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
