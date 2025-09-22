<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$grievanceTypes = GrievanceType::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
  ];
  $grievanceTypes->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalGrievanceTypes = clone $grievanceTypes;

if ($page != -1) {
  $grievanceTypes->limit($limit)->skip($skip);
}
$grievanceTypes = $grievanceTypes->get();

$pagination = Pagination::get($page, $limit, $grievanceTypes->count(), $totalGrievanceTypes->count());

$data = [
  'grievance_types' => $grievanceTypes,
  'grievance_types_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
