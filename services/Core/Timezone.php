<?php

namespace Core;

use Exception;

class Timezone
{

  public function name($offset)
  {
    try {
      if (is_string($offset)) {
        $offset = (float)$offset;
      }
      return timezone_name_from_abbr("", -$offset, 0);
    } catch (Exception $e) {
      return 'UTC';
    }
  }

  public function toUtc($time, $offset, $format = 'Y-m-d H:i:s')
  {
    $time = date($format, strtotime($time) + ($offset));
    return $time;
  }

  public function toLocal($time, $offset, $format = 'Y-m-d H:i:s')
  {
    $time = date($format, strtotime($time) - ($offset));
    return $time;
  }

  public function getOffset($tzName)
  {
    $timezone = timezone_open($tzName);
    $nowUtc = date_create('now', timezone_open('UTC'));
    return -timezone_offset_get($timezone, $nowUtc);
  }
}
