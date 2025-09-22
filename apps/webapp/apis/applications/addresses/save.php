<?php

$data = false;
$events = false;

$rules = [
  '*.address' => 'required',
  '*.city' => 'required',
  '*.post_code' => 'required',
  '*.country' => 'required',
];

$messages = [
  '*.address:required' => 'Street Address is required',
  '*.city:required' => 'City is required',
  '*.post_code:required' => 'Post Code is required',
  '*.country:required' => 'Country is required',
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
  if (is_array($latLng)) {
    $input['latitude'] = $latLng[0] ?? null;
    $input['longitude'] = $latLng[1] ?? null;
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

$data = [
  'addresses' => $addresses,
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
