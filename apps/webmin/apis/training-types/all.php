<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$trainingTypes = TrainingType::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
  ];
  $trainingTypes->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalTrainingTypes = clone $trainingTypes;

if ($page != -1) {
  $trainingTypes->limit($limit)->skip($skip);
}
$trainingTypes = $trainingTypes->get();

$pagination = Pagination::get($page, $limit, $trainingTypes->count(), $totalTrainingTypes->count());

$data = [
  'training_types' => $trainingTypes,
  'training_types_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
