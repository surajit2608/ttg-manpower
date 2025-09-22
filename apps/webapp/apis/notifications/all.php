<?php

$data = false;
$events = false;

$userId = Session::get('user_id', 0);

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$notifications = Notification::whereNull('deleted_at')
  ->where('receiver_type', 'worker')
  ->where('receiver_id', $userId)
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'content',
    'status',
  ];
  $notifications->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalNotifications = clone $notifications;

if ($page != -1) {
  $notifications->limit($limit)->skip($skip);
}
$notifications = $notifications->get();

$pagination = Pagination::get($page, $limit, $notifications->count(), $totalNotifications->count());

$data = [
  'notifications' => $notifications,
  'notifications_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
