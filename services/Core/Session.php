<?php

namespace Core;

use Input;

class Session
{

  public function __construct()
  {
    $authSession = Input::headers('Auth-Session');
    if ($authSession) {
      $this->setId($authSession);
    }
    @session_start();
    $_SESSION['_start_time'] = time();
  }

  public function getId()
  {
    return session_id();
  }

  public function setId($id)
  {
    return session_id($id);
  }

  public function get($key, $default = false)
  {
    if ($this->isExpired()) {
      $this->destroy($key);
      return $default;
    }

    if (!isset($_SESSION[$key])) {
      return $default;
    }

    $this->renew();
    return json_decode($_SESSION[$key]);
  }

  public function has($key)
  {
    if ($this->isExpired()) {
      $this->destroy($key);
      return false;
    }

    $this->renew();

    return isset($_SESSION[$key]) ? true : false;
  }

  public function set($key, $value)
  {
    $this->renew();
    $_SESSION[$key] = json_encode($value);
  }

  public function isExpired()
  {
    $startTime = $_SESSION['_start_time'];
    $startTime += 60;

    if ($startTime < time()) {
      return true;
    } else {
      return false;
    }
  }

  public function renew()
  {
    $_SESSION['_start_time'] = time();
  }

  public function destroy($key)
  {
    if (!isset($_SESSION[$key])) {
      return;
    }

    unset($_SESSION[$key]);
    $_SESSION['_start_time'] = time();
  }
}
