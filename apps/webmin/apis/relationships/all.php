<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$relationships = Relationship::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
  ];
  $relationships->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalRelationships = clone $relationships;

if ($page != -1) {
  $relationships->limit($limit)->skip($skip);
}
$relationships = $relationships->get();

$pagination = Pagination::get($page, $limit, $relationships->count(), $totalRelationships->count());

$data = [
  'relationships' => $relationships,
  'relationships_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
