<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'workers.id');
$direction = Input::get('direction', 'desc');

$workers = Worker::with('basic')
  ->select(['*', 'workers.id as id'])
  ->join('workers_basics', 'workers.id', '=', 'workers_basics.worker_id')
  ->where('workers.status', '!=', 'pending')
  ->whereNull('workers.deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'workers.id',
    'workers.first_name',
    'workers.last_name',
    'workers.account_name',
    'workers.phone',
    'workers_basics.visa_type',
    'workers_basics.visa_expiry',
    'workers_basics.passport_expiry',
    'workers.created_at',
  ];
  $workers->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalWorkers = clone $workers;

if ($page != -1) {
  $workers->limit($limit)->skip($skip);
}
$workers = $workers->get();

$pagination = Pagination::get($page, $limit, $workers->count(), $totalWorkers->count());

$data = [
  'workers' => $workers,
  'workers_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
