<?php

$data = false;
$events = false;

$documentTypes = DocumentType::whereNull('deleted_at')->orderBy('id', 'desc')->get();

$options = [];
foreach ($documentTypes as $documentType) {
  $options[] = [
    'value' => $documentType->id,
    'label' => $documentType->name,
  ];
}

$data = [
  'options_document_types' => $options,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
