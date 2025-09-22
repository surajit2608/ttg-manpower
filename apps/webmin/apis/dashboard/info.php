<?php

$data = false;
$events = false;

$adminId = Session::get('admin_id', 0);

$totalWorkers = Worker::whereNull('deleted_at')
  ->count();

$approvedWorkers = Worker::whereNull('deleted_at')
  ->where('status', 'approved')
  ->count();

$rejectedWorkers = Worker::whereNull('deleted_at')
  ->where('status', 'rejected')
  ->count();

$pendingWorkers = Worker::whereNull('deleted_at')
  ->where('status', 'active')
  ->count();

$users = User::whereNull('deleted_at')
  ->count();

$applications = Application::whereNull('deleted_at')
  ->count();

$messages = Notification::whereNull('deleted_at')
  ->where('receiver_type', 'admin')
  ->where('receiver_id', $adminId)
  ->where('status', 'unread')
  ->count();

$twentyFourHoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours', time()));
$newWorkers = Worker::whereNull('deleted_at')
  ->where('created_at', '>=', $twentyFourHoursAgo)
  ->whereIn('status', ['active', 'approved'])
  ->count();

$info = [
  'new_workers' => $newWorkers,
  'total_workers' => $totalWorkers,
  'pending_workers' => $pendingWorkers,
  'approved_workers' => $approvedWorkers,
  'rejected_workers' => $rejectedWorkers,

  'applications' => $applications,
  'system_users' => $users,
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
