<?php

$data = false;
$events = false;

$rules = [
  'addresses.*.address' => 'required',
  'addresses.*.city' => 'required',
  'addresses.*.post_code' => 'required',
  'addresses.*.country' => 'required',
  'change_log.comment' => 'required',
];

$messages = [
  'addresses.*.address:required' => 'Street Address is required',
  'addresses.*.city:required' => 'City is required',
  'addresses.*.post_code:required' => 'Post Code is required',
  'addresses.*.country:required' => 'Country is required',
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
$addresses = $inputs['addresses'] ?? [];
foreach ($addresses as $input) {
  $id = $input['id'] ?? 0;

  if (isset($input['utility_bill']) && !empty($input['utility_bill'])) {
    $utilityBill = WorkerDocument::where('worker_id', $input['worker_id'])->where('document_type_id', 5)->first();
    if (!$utilityBill) {
      $utilityBill = new WorkerDocument;
      $utilityBill->created_at = date('Y-m-d H:i:s');
    }
    $utilityBill->worker_id  = $input['worker_id'];
    $utilityBill->document_type_id = 5;
    $utilityBill->document = $input['utility_bill'];
    $utilityBill->updated_at = date('Y-m-d H:i:s');
    $utilityBill->save();
  }

  if (isset($input['bank_statement']) && !empty($input['bank_statement'])) {
    $bankStatement = WorkerDocument::where('worker_id', $input['worker_id'])->where('document_type_id', 6)->first();
    if (!$bankStatement) {
      $bankStatement = new WorkerDocument;
      $bankStatement->created_at = date('Y-m-d H:i:s');
    }
    $bankStatement->worker_id  = $input['worker_id'];
    $bankStatement->document_type_id = 6;
    $bankStatement->document = $input['bank_statement'];
    $bankStatement->updated_at = date('Y-m-d H:i:s');
    $bankStatement->save();
  }

  if (isset($input['dnla']) && !empty($input['dnla'])) {
    $dnla = WorkerDocument::where('worker_id', $input['worker_id'])->where('document_type_id', 7)->first();
    if (!$dnla) {
      $dnla = new WorkerDocument;
      $dnla->created_at = date('Y-m-d H:i:s');
    }
    $dnla->worker_id  = $input['worker_id'];
    $dnla->document_type_id = 7;
    $dnla->document = $input['dnla'];
    $dnla->updated_at = date('Y-m-d H:i:s');
    $dnla->save();
  }

  $input['latitude'] = 0;
  $input['longitude'] = 0;
  $fullAddress = $input['address'] . ', ' . $input['city'] . ', ' . $input['post_code'] . ', ' . $input['country'];
  $latLng = Address::getLatLon($fullAddress);
  if (is_array($latLng) && count($latLng)) {
    $input['latitude'] = $latLng[0];
    $input['longitude'] = $latLng[1];
  }

  $input['updated_at'] = date('Y-m-d H:i:s');
  if (!$id) {
    $input['created_at'] = date('Y-m-d H:i:s');
    $id = WorkerAddress::insertGetId($input);
  } else {
    WorkerAddress::where('id', $id)->update($input);
  }
  $ids[] = $id;
}

$addresses = WorkerAddress::whereIn('id', $ids)->get();


// Save Reason for Change
$changeLog = Input::get('change_log', []);
$changeLog['created_at'] = date('Y-m-d H:i:s');
$changeLog['updated_at'] = date('Y-m-d H:i:s');
ChangeLog::insert($changeLog);


$data = [
  'addresses' => $addresses,
  'change_log.comment' => '',
];

$events = [
  'page.init' => true,
  'message.show' => [
    'type' => 'success',
    'text' => 'Addresses successfully saved',
  ],
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
