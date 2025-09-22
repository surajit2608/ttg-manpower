<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$roles = Role::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
    'permissions',
    'created_at',
  ];
  $roles->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalRoles = clone $roles;

if ($page != -1) {
  $roles->limit($limit)->skip($skip);
}
$roles = $roles->get();

$pagination = Pagination::get($page, $limit, $roles->count(), $totalRoles->count());

$data = [
  'roles' => $roles,
  'roles_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
