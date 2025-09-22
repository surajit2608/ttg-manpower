<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$holidays = Holiday::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
    'date',
    'created_at',
  ];
  $holidays->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalHolidays = clone $holidays;

if ($page != -1) {
  $holidays->limit($limit)->skip($skip);
}
$holidays = $holidays->get();

$pagination = Pagination::get($page, $limit, $holidays->count(), $totalHolidays->count());

$data = [
  'holidays' => $holidays,
  'holidays_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
