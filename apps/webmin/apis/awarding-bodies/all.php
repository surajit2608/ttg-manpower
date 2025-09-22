<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$awardingBodies = AwardingBody::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
  ];
  $awardingBodies->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalAwardingBodies = clone $awardingBodies;

if ($page != -1) {
  $awardingBodies->limit($limit)->skip($skip);
}
$awardingBodies = $awardingBodies->get();

$pagination = Pagination::get($page, $limit, $awardingBodies->count(), $totalAwardingBodies->count());

$data = [
  'awarding_bodies' => $awardingBodies,
  'awarding_bodies_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
