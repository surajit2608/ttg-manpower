<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$nationalities = Nationality::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
  ];
  $nationalities->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalNationalities = clone $nationalities;

if ($page != -1) {
  $nationalities->limit($limit)->skip($skip);
}
$nationalities = $nationalities->get();

$pagination = Pagination::get($page, $limit, $nationalities->count(), $totalNationalities->count());

$data = [
  'nationalities' => $nationalities,
  'nationalities_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
