<?php

$data = false;
$events = false;

$rules = [
  'payrolls.*.account_holder' => 'required',
  'payrolls.*.account_number' => 'required',
  'payrolls.*.sort_code' => 'required',
  'payrolls.*.bank_name' => 'required',
  'payrolls.*.have_ni' => 'required',
  'payrolls.*.ni_number' => 'required_unless:have_ni,yes',
  'payrolls.*.p45_document' => 'required',
  'payrolls.*.employee_statement' => 'required',
  'payrolls.*.p46_document' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'payrolls.*.account_holder:required' => 'Account Holder Name is required',
  'payrolls.*.account_number:required' => 'Account Number is required',
  'payrolls.*.sort_code:required' => 'Sort Code is required',
  'payrolls.*.bank_name:required' => 'Bank Name is required',
  'payrolls.*.have_ni:required' => 'Do you have a NI Number is required',
  'payrolls.*.ni_number:required_unless' => 'NI Number is required',
  'payrolls.*.p45_document:required' => 'Upload P45 Form is required',
  'payrolls.*.employee_statement:required' => 'P46 Information is required',
  'payrolls.*.p46_document:required' => 'Upload P46 Document is required',
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

$ids = [];
$inputs = Input::all();

$payrolls = $inputs['payrolls'] ?? [];
foreach ($payrolls as $input) {
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


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'payrolls' => $payrolls,
  'change_log.comment' => '',
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
