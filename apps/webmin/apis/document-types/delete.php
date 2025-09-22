<?php

$data = false;
$events = false;

$rules = [
  'document_type.id' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'document_type.id:required' => 'No document type found',
  'change_log.comment:required' => 'Reason for Delete is required',
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

$inputs = Input::get('document_type', []);
$id = $inputs['id'] ?? 0;

DocumentType::where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'delete-document-type-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Document type successfully deleted',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
