<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$workerId = Input::get('worker_id', 0);
$direction = Input::get('direction', 'desc');

$leaves = Leave::with('holiday')
  ->select(['*', 'leaves.id as id'])
  ->join('holidays', 'leaves.holiday_id', '=', 'holidays.id')
  ->where('leaves.worker_id', $workerId)
  ->whereNull('leaves.deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'leaves.id',
    'holidays.name',
    'holidays.date',
    'leaves.message',
    'leaves.status',
    'leaves.created_at',
  ];
  $leaves->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalLeaves = clone $leaves;

if ($page != -1) {
  $leaves->limit($limit)->skip($skip);
}
$leaves = $leaves->get();

$pagination = Pagination::get($page, $limit, $leaves->count(), $totalLeaves->count());

$data = [
  'leaves' => $leaves,
  'leaves_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
