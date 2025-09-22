<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$users = User::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'first_name',
    'last_name',
    'username',
    'email',
    'phone',
    'tz_offset',
    'last_loggedin',
  ];
  $users->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalUsers = clone $users;

if ($page != -1) {
  $users->limit($limit)->skip($skip);
}
$users = $users->get();

$pagination = Pagination::get($page, $limit, $users->count(), $totalUsers->count());

$data = [
  'users' => $users,
  'users_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
