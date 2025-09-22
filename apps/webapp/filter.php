<?php

$publicUrls = [
  SITE_URL . '/login',
  SITE_URL . '/password/*',
  SITE_URL . '/application/*',
  SITE_URL . '/api/workers/*',
  SITE_URL . '/api/applications/*',
  SITE_URL . '/api/clients/options',
  SITE_URL . '/api/nationalities/options',
  SITE_URL . '/api/relationships/options',
];

foreach ($publicUrls as $url) {
  if (Request::is($url)) {
    return [
      'denied' => false,
    ];
  }
}

$userId = Session::get('user_id', 0);

if (Request::is(SITE_URL . '/login/*') && $userId) {
  return [
    'denied' => true,
    'redirect' => SITE_URL . '/dashboard',
  ];
}

if ($userId) {
  return [
    'denied' => false,
  ];
}

return [
  'denied' => true,
  'redirect' => SITE_URL . '/login',
];
