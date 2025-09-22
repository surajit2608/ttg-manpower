<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$skillsets = Skillset::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
    'wage',
    'created_at',
  ];
  $skillsets->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalSkillsets = clone $skillsets;

if ($page != -1) {
  $skillsets->limit($limit)->skip($skip);
}
$skillsets = $skillsets->get();

$pagination = Pagination::get($page, $limit, $skillsets->count(), $totalSkillsets->count());

$data = [
  'skillsets' => $skillsets,
  'skillsets_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
