<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$documents = WorkerDocument::with('document_type')->whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'document_type_id',
    'document',
  ];
  $documents->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalDocuments = clone $documents;

if ($page != -1) {
  $documents->limit($limit)->skip($skip);
}
$documents = $documents->get();

$pagination = Pagination::get($page, $limit, $documents->count(), $totalDocuments->count());

$data = [
  'documents' => $documents,
  'documents_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
