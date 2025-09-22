<?php

$data = false;
$events = false;

$page = Input::get('page', -1);
$limit = Input::get('limit', 25);
$skip = $limit * ((int)$page - 1);
$search = Input::get('search', null);
$direction = Input::get('direction', 'desc');
$column = Input::get('column', 'applications.id');

$applications = Application::with('job', 'client')
  ->select(['*', 'applications.id as id'])
  ->join('jobs', 'applications.job_id', '=', 'jobs.id')
  ->join('clients', 'applications.client_id', '=', 'clients.id')
  ->whereNull('applications.deleted_at')
  ->orderBy($column, $direction);

if ($search) {
  $columns = [
    'applications.id',
    'applications.title',
    'jobs.name',
    'clients.business_name',
    'applications.address',
    'applications.city',
    'applications.post_code',
    'applications.country',
    'applications.hourly_salary',
    'applications.created_at',
  ];
  $applications->where(function ($query) use (&$columns, &$search) {
    foreach ($columns as $column) {
      $query->orWhere($column, 'like', '%' . $search . '%');
    }
  });
}

$totalApplications = clone $applications;

if ($page != -1) {
  $applications->limit($limit)->skip($skip);
}
$applications = $applications->get();

$pagination = Pagination::get($page, $limit, $applications->count(), $totalApplications->count());

$data = [
  'applications' => $applications,
  'applications_loaded' => true,
  'pagination' => $pagination,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events,
];
