<?php

namespace Core;

use DB;
use Request;
use Console;

class Response
{

  public function html($q)
  {
    $view = Load('Core\View');
    $data = [];
    $dataFile = SECTION . '/data.php';
    if (file_exists($dataFile)) {
      $data = include $dataFile;
      $data['__root__'] = $data;
    }
    http_response_code(200);
    header('Content-Type: text/html');
    echo $view->render($q, $data);
  }

  public function sql()
  {
    return DB::getQueryLog();
  }

  public function json($input)
  {
    if (!is_array($input) && !is_object($input)) {
      $file = SECTION . '/' . $input . '.php';
      $input = include $file;
    }

    if (DEBUG && AJAX) {
      $input['Console-Log-Server'] = Console::getServerLog();
    }

    $this->setHeaders();
    http_response_code(200);
    echo json_encode($input);
  }

  public function filter()
  {
    $filter = [];
    $filterFile = SECTION . '/filter.php';
    if (file_exists($filterFile)) {
      $filter = include $filterFile;
    }

    if (!isset($filter['denied'])) {
      $filter['denied'] = false;
    }
    if (!isset($filter['redirect'])) {
      $filter['redirect'] = '/';
    }
    if (Request::is($filter['redirect'])) {
      $filter['denied'] = false;
    }
    $filter = (object)$filter;
    return $filter;
  }

  public function redirect($url, $check = true)
  {
    if ($check && Request::isAjax()) {
      echo json_encode([
        'data' => false,
        'events' => [
          'page.redirect' => $url,
        ],
      ]);
      die;
    }
    header('Location: ' . $url);
    die;
  }

  public function options()
  {
    $this->setHeaders();
    http_response_code(200);
    echo '{}';
    die;
  }

  private function setHeaders()
  {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT');
    header('Content-Type: application/json');
  }

  public function error($code)
  {
    if ($code == 404) {
      return $this->notFoundError();
    } else {
      return $this->unknownServerError();
    }
  }

  private function notFoundError()
  {
    http_response_code(404);
    if (Request::isAjax()) {
      echo json_encode([
        'type' => 'error',
        'message' => 'Not Found, Please report us'
      ]);
      die;
    }
    include BASE_DIR . '/apps/errors/404.php';
    die;
  }

  private function unknownServerError()
  {
    http_response_code(500);
    if (Request::isAjax()) {
      echo json_encode([
        'type' => 'error',
        'message' => 'Server Error, Please report us'
      ]);
      die;
    }
    include BASE_DIR . '/apps/errors/500.php';
    die;
  }
}
