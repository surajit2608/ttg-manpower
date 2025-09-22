<?php

$data = false;
$events = false;

$inputs = Input::get('document_type', []);

$id = $inputs['id'] ?? 0;

$rules = [
  'document_type.name' => 'required',
];

if ($id) {
  $rules['change_log.comment'] = 'required';
}

$messages = [
  'document_type.name:required' => 'Document type is required',
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

$name = $inputs['name'] ?? null;

$documentType = DocumentType::find($id);
$checkDocumentType = DocumentType::where('name', $name);

if (!$documentType) {
  $checkDocumentType = $checkDocumentType->first();
  if ($checkDocumentType) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A document type is already exists',
      ],
    ];
    goto RESPONSE;
  }
  $documentType = new DocumentType;
  $documentType->created_at = date('Y-m-d H:i:s');
} else {
  $checkDocumentType = $checkDocumentType->where('id', '!=', $documentType->id)->first();
  if ($checkDocumentType) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'A document type is already exists',
      ],
    ];
    goto RESPONSE;
  }
}

$documentType->name = $name;
$documentType->updated_at = date('Y-m-d H:i:s');
$documentType->save();

// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);

$events = [
  'page.init' => true,
  'modal.close' => 'add-document-type-modal',
  'message.show' => [
    'type' => 'success',
    'text' => 'Document Type successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
