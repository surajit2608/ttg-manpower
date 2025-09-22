<?php

$data = false;
$events = false;

$weeklyWorkingHours = 48;
$userId = Session::get('user_id', 0);

$user = Worker::find($userId);
$application = Application::find($user->application_id);

$lastMonday = date('Y-m-d 00:00:00', strtotime('this week'));

$workedHours = Attendance::whereNull('deleted_at')
  ->where('created_at', '>=', $lastMonday)
  ->where('worker_id', $userId)
  ->sum('hours');

$workRemain = round($weeklyWorkingHours - $workedHours, 2);

$workedAmount = round($workedHours * $application->hourly_salary, 2);

$leavesApplied = Leave::whereNull('deleted_at')
  ->where('worker_id', $userId)
  ->count();

$messages = Notification::whereNull('deleted_at')
  ->where('receiver_type', 'worker')
  ->where('receiver_id', $userId)
  ->where('status', 'unread')
  ->count();

$info = [
  'last_week_worked_hours' => round($workedHours, 2),
  'last_week_work_hours_remain' => $workRemain,
  'last_week_worked_amount' => $workedAmount,
  'leaves_applied' => $leavesApplied,
  'new_messages' => $messages,
];

$data = [
  'info' => $info,
  'info_loaded' => true
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
