<?php

$data = false;
$events = false;

$rules = [
  '*.account_holder' => 'required',
  '*.account_number' => 'required',
  '*.sort_code' => 'required',
  '*.bank_name' => 'required',
  '*.have_ni' => 'required',
  '*.ni_number' => 'required_unless:have_ni,yes',
  '*.p45_document' => 'required',
  '*.employee_statement' => 'required',
  '*.p46_document' => 'required',
];

$messages = [
  '*.account_holder:required' => 'Account Holder Name is required',
  '*.account_number:required' => 'Account Number is required',
  '*.sort_code:required' => 'Sort Code is required',
  '*.bank_name:required' => 'Bank Name is required',
  '*.have_ni:required' => 'Do you have a NI Number is required',
  '*.ni_number:required_unless' => 'NI Number is required',
  '*.p45_document:required' => 'Upload P45 Form is required',
  '*.employee_statement:required' => 'P46 Information is required',
  '*.p46_document:required' => 'Upload P46 Document is required',
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

$ids = [];
$inputs = Input::all();

foreach ($inputs as $input) {
  $id = $input['id'] ?? 0;

  if (isset($input['bank_letter']) && !empty($input['bank_letter'])) {
    $bankLetter = WorkerDocument::where('worker_id', $input['worker_id'])->where('document_type_id', 4)->first();
    if (!$bankLetter) {
      $bankLetter = new WorkerDocument;
      $bankLetter->created_at = date('Y-m-d H:i:s');
    }
    $bankLetter->worker_id  = $input['worker_id'];
    $bankLetter->document_type_id = 4;
    $bankLetter->document = $input['bank_letter'];
    $bankLetter->updated_at = date('Y-m-d H:i:s');
    $bankLetter->save();
  }

  $input['updated_at'] = date('Y-m-d H:i:s');

  if (!$id) {
    $input['created_at'] = date('Y-m-d H:i:s');
    $id = WorkerPayroll::insertGetId($input);
  } else {
    WorkerPayroll::where('id', $id)->update($input);
  }
  $ids[] = $id;
}

$payrolls = WorkerPayroll::whereIn('id', $ids)->get();

$data = [
  'payrolls' => $payrolls,
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Payroll Information successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
