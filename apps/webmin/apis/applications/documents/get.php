<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$workerId = Input::get('worker_id', 0);
$direction = Input::get('direction', 'desc');
$column = Input::get('column', 'workers_documents.id');

$documents = WorkerDocument::with('document_type')
  ->select(['*', 'workers_documents.id as id'])
  ->join('document_types', 'workers_documents.document_type_id', '=', 'document_types.id')
  ->where('workers_documents.worker_id', $workerId)
  ->whereNull('workers_documents.deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'workers_documents.id',
    'document_types.name',
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
