<?php

$data = false;
$events = false;

$rules = [
  'document.worker_id' => 'required',
  'document.document_type_id' => 'required',
  'document.document' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'document.worker_id:required' => 'Worker is required',
  'document.document_type_id:required' => 'Document type is required',
  'document.document:required' => 'Document is required',
  'change_log.comment:required' => 'Reason for Change is required',
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

$inputs = Input::get('document', []);
$id = $inputs['id'] ?? 0;

$inputs['updated_at'] = date('Y-m-d H:i:s');

if (!$id) {
  $inputs['created_at'] = date('Y-m-d H:i:s');
  $id = WorkerDocument::insertGetId($inputs);
} else {
  WorkerDocument::where('id', $id)->update($inputs);
}

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


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
