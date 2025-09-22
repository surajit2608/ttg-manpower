<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$grievances = WorkerGrievance::with('grievance_type')->whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'grievance_type_id',
    'grievance_date',
    'grievance_time',
    'comments',
  ];
  $grievances->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalGrievances = clone $grievances;

if ($page != -1) {
  $grievances->limit($limit)->skip($skip);
}
$grievances = $grievances->get();

$pagination = Pagination::get($page, $limit, $grievances->count(), $totalGrievances->count());

$data = [
  'grievances' => $grievances,
  'grievances_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
