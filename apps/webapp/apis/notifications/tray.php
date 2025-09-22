<?php

$data = false;
$events = false;

$userId = Session::get('user_id', 0);

$limit = Input::get('limit', 15);

$notifications = Notification::whereNull('deleted_at')
  ->where('receiver_type', 'worker')
  ->where('receiver_id', $userId);

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
