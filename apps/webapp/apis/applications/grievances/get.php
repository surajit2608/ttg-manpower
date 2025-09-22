<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$workerId = Input::get('worker_id', 0);
$direction = Input::get('direction', 'desc');
$column = Input::get('column', 'workers_grievances.id');

$grievances = WorkerGrievance::with('grievance_type')
  ->select(['*', 'workers_grievances.id as id'])
  ->join('grievance_types', 'workers_grievances.grievance_type_id', '=', 'grievance_types.id')
  ->where('workers_grievances.worker_id', $workerId)
  ->whereNull('workers_grievances.deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'workers_grievances.id',
    'grievance_types.name',
    'workers_grievances.grievance_date',
    'workers_grievances.grievance_time',
    'workers_grievances.comments',
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
