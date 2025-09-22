<?php

namespace Core;

class Request
{

  public function is($url)
  {
    $request_url = '/';
    if (isset($_SERVER['REDIRECT_URL'])) {
      $request_url = $_SERVER['REDIRECT_URL'];
    } elseif (isset($_SERVER['REQUEST_URI'])) {
      $request_url = $_SERVER['REQUEST_URI'];
    }

    $url = trim($url, '/');
    $request_url = trim($request_url, '/');

    if (preg_match("#^$url#", $request_url)) {
      return true;
    } else {
      return false;
    }
  }

  public function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function isAjax()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      return true;
    } else {
      return false;
    }
  }

  public function header($key)
  {
    $key = 'HTTP_' . $key;
    $key = str_replace('-', '_', $key);
    $key = strtoupper($key);
    if (isset($_SERVER[$key])) {
      return $_SERVER[$key];
    } else {
      return false;
    }
  }

  public function path()
  {
    $path = parse_url($_SERVER['REQUEST_URI']);
    return (object)$path;
  }

  public function params()
  {
    $params = [];
    $path = $this->path();
    $segments = explode('/', ltrim(rtrim($path->path, '/'), '/'));
    foreach ($segments as $param) {
      if (!$this->is($param)) {
        $params[] = $param;
      }
    }
    return $params;
  }
}
