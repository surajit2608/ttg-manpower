<?php

$data = false;
$events = false;

$userId = Session::get('user_id', 0);

$rules = [
  'holiday_id' => 'required',
  'message' => 'required',
];

$messages = [
  'holiday_id:required' => 'Holiday is required',
  'message:required' => 'Message is required',
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
$holidayId = Input::get('holiday_id', 0);
$message = Input::get('message', null);

$worker = Worker::find($userId);
$holiday = Holiday::find($holidayId);

$leave = Leave::find($id);
$checkLeave = Leave::where(function ($query) use (&$holidayId, &$userId) {
  $query->orWhere('holiday_id', $holidayId);
  $query->orWhere('worker_id', $userId);
});

if (!$leave) {
  $checkLeave = $checkLeave->first();
  if ($checkLeave) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A Leave is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $leave = new Leave;
  $leave->created_at = date('Y-m-d H:i:s');

  $subject = 'Leave Application Submitted';
  $notificationBody = $worker->account_name . ' has submitted a leave application for ' . $holiday->name . ' on ' . $holiday->date;
  $emailBody = '<p>Hi</p><p>' . $worker->account_name . ' has submitted a leave application for ' . $holiday->name . ' on ' . $holiday->date . '</p>';
} else {
  $checkLeave = $checkLeave->where('id', '!=', $leave->id)->first();
  if ($checkLeave) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A Leave is already exists',
      ],
    ];
    goto RESPONSE;
  }

  $subject = 'Leave Application Re-Submitted';
  $notificationBody = $worker->account_name . ' has resubmitted a leave application for ' . $holiday->name . ' on ' . $holiday->date;
  $emailBody = '<p>Hi</p><p>' . $worker->account_name . ' has resubmitted a leave application for ' . $holiday->name . ' on ' . $holiday->date . '</p>';
}

$leave->holiday_id = $holidayId;
$leave->worker_id = $userId;
$leave->message = $message;
$leave->status = 'pending';
$leave->updated_at = date('Y-m-d H:i:s');
$leave->save();

$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
$url = ADMIN_URL . '/workers/leaves/?id=' . $worker->id;
Notify::toAdmin('holiday', $contents, $url);

$events = [
  'page.init' => true,
  'modal.close' => 'apply-leave-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Leave successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
