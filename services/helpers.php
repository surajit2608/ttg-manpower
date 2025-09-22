<?php

use ScssPhp\ScssPhp\Compiler;

function Load($module)
{
  global $container;

  $key = strtolower($module);
  $key = str_replace('\\', '.', $key);

  if (!$container->has($key)) {
    $container->add($key, new $module);
  }
  return $container->get($key);
}

function log_error($message)
{
  global $log;

  $message = json_encode($message);
  $log->error($message);
}

function d($var, $option = 'json')
{
  debug($var, $option);
}

function debug($var, $option = 'json')
{
  echo "<pre>";
  $die = true;
  if ($option == 'php|continue' || $option == 'p|c') {
    $die = false;
    $response = var_export($var);
  } elseif ($option == 'json|continue' || $option == 'j|c') {
    $die = false;
    $response = json_encode($var);
  } elseif ($option == 'continue' || $option == 'c') {
    $die = false;
    $response = json_encode($var);
  } elseif ($option == 'php' || $option == 'p') {
    $response = var_export($var);
  } else {
    $response = json_encode($var);
  }

  RESPONSE:
  echo $response;
  if ($die) die;
}

function jsAddSlashes($str)
{
  $pattern = array(
    "/\\\\/", "/\n/", "/\r/", "/\"/",
    "/\'/", "/&/", "/</", "/>/"
  );
  $replace = array(
    "\\\\\\\\", "\\n", "\\r", "\\\"",
    "\\'", "\\x26", "\\x3C", "\\x3E"
  );
  return preg_replace($pattern, $replace, $str);
}

function deepClone($data, $toArray = false)
{
  return json_decode(json_encode($data), $toArray);
}

function clean($string)
{
  $string = str_replace(' ', '_', $string);
  return preg_replace('/[^A-Za-z0-9\_]/', '', $string);
}

function randomPassword($length = 6)
{
  $pass = [];
  $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%&*_-";
  $alphaLength = strlen($alphabet) - 1;
  for ($i = 0; $i < $length; $i++) {
    $n = rand(0, $alphaLength);
    $pass[] = $alphabet[$n];
  }
  return implode($pass);
}

if (!function_exists('apache_request_headers')) {
  function apache_request_headers()
  {
    $arh = array();
    $rx_http = '/\AHTTP_/';
    foreach ($_SERVER as $key => $val) {
      if (preg_match($rx_http, $key)) {
        $arh_key = preg_replace($rx_http, '', $key);
        $rx_matches = array();
        $rx_matches = explode('_', strtolower($arh_key));
        if (count($rx_matches) > 0 and strlen($arh_key) > 2) {
          foreach ($rx_matches as $ak_key => $ak_val)
            $rx_matches[$ak_key] = ucfirst($ak_val);
          $arh_key = implode('-', $rx_matches);
        }
        $arh[$arh_key] = $val;
      }
    }
    if (isset($_SERVER['CONTENT_TYPE']))
      $arh['Content-Type'] = $_SERVER['CONTENT_TYPE'];
    if (isset($_SERVER['CONTENT_LENGTH']))
      $arh['Content-Length'] = $_SERVER['CONTENT_LENGTH'];

    return ($arh);
  }
}

function compileScss($name)
{
  $compiler = new Compiler();
  $compiler->setImportPaths(BASE_DIR . '/public/assets/scss/');
  $compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);
  $compiler->setSourceMapOptions([
    'sourceMapURL' => $name . '.css.map',
    'sourceMapFilename' => $name . '.css',
    'sourceMapBasepath' => BASE_DIR,
    'sourceRoot' => '/',
  ]);
  $result = $compiler->compileString('@import "' . $name . '.scss";');
  file_put_contents(BASE_DIR . '/public/assets/css/' . $name . '.css.map', $result->getSourceMap());
  file_put_contents(BASE_DIR . '/public/assets/css/' . $name . '.css', $result->getCss());
}
