<?php

$publicUrls = [
  ADMIN_URL . '/login',
  ADMIN_URL . '/password/*',
  ADMIN_URL . '/api/users/*',
];

foreach ($publicUrls as $url) {
  if (Request::is($url)) {
    return [
      'denied' => false,
    ];
  }
}

$adminId = Session::get('admin_id', 0);

if (Request::is(ADMIN_URL . '/login/*') && $adminId) {
  return [
    'denied' => true,
    'redirect' => ADMIN_URL . '/dashboard',
  ];
}

if ($adminId) {
  return [
    'denied' => false,
  ];
}

return [
  'denied' => true,
  'redirect' => ADMIN_URL . '/login',
];
