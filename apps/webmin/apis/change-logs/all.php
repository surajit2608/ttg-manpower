<?php

$data = false;
$events = false;

$id = Input::get('id', 0);
$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$type = Input::get('type', null);
$search = Input::get('search', null);
$column = Input::get('column', 'change_logs.id');
$direction = Input::get('direction', 'desc');


$changeLogs = ChangeLog::whereNull('change_logs.deleted_at')
  ->leftJoin('users', 'users.id', '=', 'change_logs.user_id')
  ->where('change_logs.type', 'LIKE', '%' . $type . '%')
  ->orderBy($column, $direction);

if ($id) {
  $changeLogs->where('change_logs.record_id', $id);
}

if ($search) {
  $columns = [
    'users.full_name',
    'change_logs.method',
    'change_logs.comment',
    'change_logs.created_at',
  ];
  $changeLogs->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalChangeLogs = clone $changeLogs;

if ($page != -1) {
  $changeLogs->limit($limit)->skip($skip);
}
$changeLogs = $changeLogs->get();

$pagination = Pagination::get($page, $limit, $changeLogs->count(), $totalChangeLogs->count());

$data = [
  'change_logs' => $changeLogs,
  'change_logs_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
