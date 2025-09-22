<?php

namespace Core;

use Request;

class Route
{

  private $_urls = [];
  private $_methods = [];

  public function add($path, $method = null)
  {
    $this->_urls[] = $path;
    if ($method) {
      $this->_methods[] = $method;
    }
  }

  public function allow()
  {
    $currentPath = Request::path();
    foreach ($this->_urls as $key => $value) {
      if (preg_match("#^$value$#", $currentPath->path)) {
        return call_user_func($this->_methods[$key]);
      }
    }
  }
}
