<?php

define('ASSETS_V', '1.0.0');

// Checking AJAX Request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  $ajax = true;
} else {
  $ajax = false;
}

define('AJAX', $ajax);

date_default_timezone_set('UTC');
define('SERVER_TIMEZONE', date_default_timezone_set('UTC'));


// Initialing Vendor Autoloader
$loader = include BASE_DIR . '/vendor/autoload.php';
$loader->addPsr4(false, BASE_DIR . '/models');
$loader->addPsr4(false, BASE_DIR . '/services');

// Include helper Function
include BASE_DIR . '/services/helpers.php';

// compile scss
compileScss('app');
compileScss('theme');
compileScss('responsive');

// Setting Error Logger
$log = new Monolog\Logger('LOGS');
$log_path = LOGS_DIR . '/' . date('Y-m-d') . '.log';
$log->pushHandler(new Monolog\Handler\StreamHandler($log_path, Monolog\Logger::DEBUG));


// Setting Error Logger
$whoops = new \Whoops\Run;

if (DEBUG && !AJAX) {
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} elseif (DEBUG) {
  $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
}

$whoops->pushHandler(function ($exception, $exceptionInspector) use ($log) {

  $frames = $exceptionInspector->getFrames();
  $frames->filter(function ($frame) {
    $filePath = $frame->getFile();
    return !strpos($filePath, '/vendor/');
  });

  $frameFile = '';
  $errorLogs = [];

  Console::error($exception->getMessage());

  foreach ($frames as $frame) {
    if ($frameFile == $frame->getFile()) {
      continue;
    }
    $frameFile = $frame->getFile();
    $frameFile = str_replace(__DIR__, '', $frameFile);

    if (strpos($frameFile, '/vendor/') !== false) {
      continue;
    }
    if (strpos($frameFile, 'services/Facade.php') !== false) {
      continue;
    }

    $errorLogs[] = $frame->getLine() . ':' . $frameFile;
    Console::error($frame->getLine() . ':' . $frameFile);
    if (strpos($frameFile, 'index.php') !== false) {
      break;
    }
  }

  $errorLogs[] = 'url: ' . FULL_URL;
  $errorLogs[] = 'path: ' . $_SERVER['REQUEST_URI'];
  $errorLogs[] = 'user: ' . Session::get('user_id', 0);
  $errorLogs[] = 'app: ' . Input::get('app', 0);
  $errorLogs[] = 'flow: ' . Input::get('flow', 0);
  $errorLogs[] = 'logs: ' . Console::getLogs();

  $log->error($exception->getMessage(), $errorLogs);

  if (DEBUG) {
    header('Console-Log-Server: ' . Console::getServerLog());
    return \Whoops\Handler\Handler::DONE;
  }
  include BASE_DIR . '/apps/errors/500.php';
});

$whoops->register();


// Initialing Service Container
$container = new League\Container\Container;


// Set Access Control Origin for Cross Domain
header('Access-Control-Allow-Origin: *');


// Include PHPMailer for sending emails
$PHPMailer = new PHPMailer\PHPMailer\PHPMailer();
