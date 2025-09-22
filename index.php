<?php

// Config files
include __DIR__ . '/config/app.php';
include __DIR__ . '/config/paths.php';
include __DIR__ . '/config/email.php';
include __DIR__ . '/config/google.php';
include __DIR__ . '/config/others.php';
include __DIR__ . '/config/database.php';


include __DIR__ . '/boot.php';

$uri = $_SERVER['REDIRECT_URL'] ?? '/';
$uri = str_replace(SITE_URL, '/', $uri);
$uri = ltrim($uri, '/');
$uri = rtrim($uri, '/');
if (strpos($uri, '/-dev') === false) {
  include __DIR__ . '/config.php';
}

include __DIR__ . '/route.php';
