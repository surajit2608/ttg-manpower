<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$column = Input::get('column', 'id');
$direction = Input::get('direction', 'desc');

$documentTypes = DocumentType::whereNull('deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'id',
    'name',
  ];
  $documentTypes->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalDocumentTypes = clone $documentTypes;

if ($page != -1) {
  $documentTypes->limit($limit)->skip($skip);
}
$documentTypes = $documentTypes->get();

$pagination = Pagination::get($page, $limit, $documentTypes->count(), $totalDocumentTypes->count());

$data = [
  'document_types' => $documentTypes,
  'document_types_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
