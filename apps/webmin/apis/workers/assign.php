<?php

$data = false;
$events = false;

$rules = [
  'worker_id' => 'required',
  'application_id' => 'required',
  'shift_start_time' => 'required',
  'shift_end_time' => 'required',
  'availabilities' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'worker_id:required' => 'No worker found',
  'application_id:required' => 'No job application found',
  'shift_start_time:required' => 'Shift Start Time is required',
  'shift_end_time:required' => 'Shift End Time is required',
  'availabilities:required' => 'Choose date to assign workers',
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

$adminId = Session::get('admin_id', 0);
$workerId = Input::get('worker_id', 0);
$applicationId = Input::get('application_id', 0);
$shiftStartTime = Input::get('shift_start_time', null);
$shiftEndTime = Input::get('shift_end_time', null);
$availabilities = Input::get('availabilities', []);

$worker = Worker::find($workerId);
$worker->application_id = $applicationId;
$worker->joining_date = date('Y-m-d');
$worker->save();

$application = Application::find($applicationId);

$workerAvailabilities = [];
foreach ($availabilities as $date => $availability) {
  $availability = (object)$availability;
  if (!$availability->checked) {
    continue;
  }

  $workerAvailabilities[] = [
    'date' => $date,
    'user_id' => $adminId,
    'worker_id' => $workerId,
    'shift_start_time' => date('H:i:00', strtotime($shiftStartTime)),
    'shift_end_time' => date('H:i:00', strtotime($shiftEndTime)),
    'job_id' => $application->job_id,
    'application_id' => $applicationId,
    'client_id' => $application->client_id,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
  ];
}
WorkerAssignment::insert($workerAvailabilities);

$subject = 'Job Assigned';
$notificationBody = 'You have assigned for a job named ' . $application->title;
$emailBody = '<p>Hi ' . $worker->first_name . '</p><p>Your have assigned for a job named ' . $application->title . '.</p>';
$contents = [
  'email' => $emailBody,
  'subject' => $subject,
  'notification' => $notificationBody,
];
$url = SITE_URL . '/jobs';
Notify::toWorker($worker, $contents, $url);

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'onPressSearchWorkers' => true,
  'modal.close' => 'assign-worker-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Worker successfully assigned',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
