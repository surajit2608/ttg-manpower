<?php

namespace Core;

use File;

class Cache
{

  public function get($key)
  {
    $cache = $this->isExpired($key);
    if (!$cache) {
      return null;
    }

    return $cache->value;
  }

  public function has($key)
  {
    return File::has($this->path($key));
  }

  public function set($key, $value, $expiry = 0)
  {
    $cache = (object)[
      'value' => $value,
      'expired_on' => $expiry ? time() + $expiry : 0,
    ];

    return File::write($this->path($key), json_encode($cache));
  }

  public function delete($key)
  {
    return File::delete($this->path($key));
  }

  public function isExpired($key)
  {
    if (!$this->has($key)) {
      return null;
    }

    $time = time();

    $cache = File::read($this->path($key));
    $cache = json_decode($cache);
    if (!$cache->expired_on) {
      $cache->expired_on = $time + 900;
    }
    if ($time > $cache->expired_on) {
      return null;
    }

    return $cache;
  }

  public function clean()
  {
    return File::clean(UPLOAD_DIR);
  }

  private function path($key)
  {
    return UPLOAD_DIR . '/cache/' . $key . '.json';
  }
}
