<?php

$method = Request::method();

if ($method == 'OPTIONS') {
  Response::options();
}

if (!isset($_SERVER['REDIRECT_URL'])) {
  $uri = '/';
} else {
  $uri = $_SERVER['REDIRECT_URL'];
}
$uri = str_replace(SITE_URL, '/', $uri);
$uri = ltrim($uri, '/');
$uri = rtrim($uri, '/');

$params = explode('/', $uri);
if (!isset($params[0]) || !$params[0]) {
  $params = ['index'];
}

$module = '';
switch ($params[0]) {
  case '-dev':
    $section = '-devs';
    break;
  case '-test':
    $section = '-tests';
    break;
  case 'callback':
    $section = 'callbacks';
    break;
  case 'utility':
    $section = 'utilities';
    break;
  case 'common':
    $module = '/pages';
    $section = 'common';
    break;
  case 'admin':
    $module = '/pages';
    $section = 'webmin';
    break;
  default:
    $module = '/pages';
    $section = 'webapp';
    break;
}

if ($section != 'webapp') {
  array_shift($params);
}
if (!isset($params[0]) || !$params[0]) {
  $params = ['index'];
}

$page = 'index';
switch ($params[0]) {
  case 'api':
    array_shift($params);
    $module = '/apis';
    break;
}

if (count($params)) {
  $path = '';
} else {
  $path = '/index';
}

foreach ($params as $i => $param) {
  $path .= '/' . $param;
  $file = BASE_DIR . '/apps/' . $section . $module . $path;
  if (file_exists($file . '.php')) {
    $page = $param;
    break;
  }
}

$file = BASE_DIR . '/apps/' . $section . $module . $path;
if (!file_exists($file . '.php')) {
  $path = $path . '/index';
}
$file = BASE_DIR . '/apps/' . $section . $module . $path;


// Dynamic URLs
$publicUrls = [];
$rewriteUrls = [];
if (strpos($uri, '/-dev') === false && $module != '/apis') {
  $dynamicUrls = [
    [
      "url" => "application/*",
      "path" => "/application/index",
      "is_public" => false,
    ]
  ];
  foreach ($dynamicUrls as $dynamicUrl) {
    $dynamicUrl = (object)$dynamicUrl;
    $dynamicTrimUrl = ltrim($dynamicUrl->url, '/');
    $dynamicTrimUrl = rtrim($dynamicTrimUrl, '/');
    if (strpos($dynamicTrimUrl, '*') !== false && fnmatch($dynamicTrimUrl, $uri)) {
      $dynamicTrimUrl = $uri;
    }
    $rewriteUrls[$dynamicTrimUrl] = $dynamicUrl->path;
    if ($dynamicUrl->is_public) {
      $publicUrls[] = $dynamicTrimUrl;
    }
  }
}

if (!file_exists($file . '.php') || isset($rewriteUrls[$uri])) {
  // Check dynamic urls in DB;
  $path = $rewriteUrls[$uri] ?? null;
  $file = BASE_DIR . '/apps/' . $section . $module . $rewriteUrls[$uri];
  if (!file_exists($file . '.php')) {
    $page = 'index';
    $path = $path . '/index';
    $file = $file . '/index';
  } else {
    $pageParts = explode('/', $rewriteUrls[$uri]);
    $page = $pageParts[count($pageParts) - 1];
  }
  $module = '/pages';
  $section = 'webapp';
}
// Dynamic URLs


if (!file_exists($file . '.php')) {
  $page = '404';
  $module = '/pages';
  $section = 'errors';
}

define('PAGE',    $page);
define('SECTION', BASE_DIR . '/apps/' . $section);

$filter = Response::filter();

if ($filter->denied) {
  Response::redirect($filter->redirect, true);
}


if ($module == '/pages') {
  Response::html($path);
} elseif ($module == '/apis') {
  Response::json($module . $path);
} else {
  include SECTION . $module . $path . '.php';
}
