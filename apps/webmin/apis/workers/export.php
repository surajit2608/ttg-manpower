<?php

$data = false;
$events = false;

$search = Input::get('search', null);
$column = Input::get('column', 'workers.id');
$direction = Input::get('direction', 'desc');

$workers = Worker::with('basic')
  ->select(['*', 'workers.id as id'])
  ->join('workers_basics', 'workers.id', '=', 'workers_basics.worker_id')
  ->where('workers.status', '!=', 'pending')
  ->whereNull('workers.deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'workers.id',
    'workers.first_name',
    'workers.last_name',
    'workers.account_name',
    'workers.phone',
    'workers_basics.visa_type',
    'workers_basics.visa_expiry',
    'workers_basics.passport_expiry',
    'workers.created_at',
  ];
  $workers->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$workers = $workers->get();

$csvPath = '/csvs';
$exportPath = UPLOAD_DIR . $csvPath;
if (!file_exists($exportPath)) {
  mkdir($exportPath, 0777, true);
}

$fileName = time() . '.csv';
$file = $exportPath . '/' . $fileName;
$csvFile = League\Csv\Writer::createFromPath($file, 'w');
$exportUrl = UPLOAD_URL . '/' . $csvPath . '/' . $fileName;

$csvFile->insertOne([
  'Title', 'First Name', 'Middle Name', 'Last Name', 'Account Name',
  'Image', 'Gender', 'Date of Birth',
  'Email', 'Username', 'Phone',
  'Joining Date', 'Client Start Date', 'Client End Date', 'Holidays Entitlement',
]);

$records = [];
foreach ($workers as $worker) {
  $records[] = [
    $worker->title, $worker->first_name, $worker->middle_name, $worker->last_name, $worker->account_name,
    $worker->image, $worker->gender, $worker->dob,
    $worker->email, $worker->username, $worker->phone,
    $worker->joining_date, $worker->client_start_date, $worker->client_end_date, $worker->holidays_entitlement,
  ];
}
$csvFile->insertAll($records);

$events = [
  'page.redirect.newtab' => $exportUrl,
];


RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
