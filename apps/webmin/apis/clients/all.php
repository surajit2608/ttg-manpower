<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$clients = Client::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'business_name',
    'contact_person',
    'email',
    'phone',
  ];
  $clients->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalClients = clone $clients;

if ($page != -1) {
  $clients->limit($limit)->skip($skip);
}
$clients = $clients->get();

$pagination = Pagination::get($page, $limit, $clients->count(), $totalClients->count());

$data = [
  'clients' => $clients,
  'clients_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
