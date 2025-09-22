<?php

$data = false;
$events = false;

$adminId = Session::get('admin_id', 0);

$limit = Input::get('limit', 15);

$notifications = Notification::whereNull('deleted_at')
  ->where('receiver_type', 'admin')
  ->where('receiver_id', $adminId);

$unreadNotifications = clone $notifications;

$notifications = $notifications->orderBy('id', 'desc')
  ->limit($limit)
  ->get();

$unreadNotificationCount = $unreadNotifications->where('status', 'unread')->count();

$data = [
  '$notifications' => $notifications,
  '$unreadNotificationCount' => $unreadNotificationCount,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
