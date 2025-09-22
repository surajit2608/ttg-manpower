<?php

$data = false;
$events = false;

$inputs = Input::all();
$id = $inputs['id'] ?? 0;

$rules = [
  'worker_id' => 'required',
  'document_type_id' => 'required',
  'document' => 'required',
];

$messages = [
  'worker_id:required' => 'Worker is required',
  'document_type_id:required' => 'Document type is required',
  'document:required' => 'Document is required',
];

$errors = Input::validate($rules, $messages);
if ($errors) {
  $events = [
    'message.show' => [
      'type' => 'error',
      'text' => $errors[0],
    ],
  ];
  goto RESPONSE;
}

$inputs['updated_at'] = date('Y-m-d H:i:s');

if (!$id) {
  $inputs['created_at'] = date('Y-m-d H:i:s');
  $id = WorkerDocument::insertGetId($inputs);
} else {
  WorkerDocument::where('id', $id)->update($inputs);
}

$events = [
  'page.init' => true,
  'modal.close' => 'add-document-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Document successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
