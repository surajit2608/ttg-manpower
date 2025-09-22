<?php


class Facade
{

  public static function __callStatic($method, $arguments)
  {

    $instance = static::getFacadeInstance();

    if (!method_exists($instance, $method)) {
      throw static::getFacadeException($method, $arguments);
    }

    switch (count($arguments)) {
      case 0:
        return $instance->$method();
      case 1:
        return $instance->$method($arguments[0]);
      case 2:
        return $instance->$method($arguments[0], $arguments[1]);
      case 3:
        return $instance->$method($arguments[0], $arguments[1], $arguments[2]);
      case 4:
        return $instance->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
      default:
        return call_user_func_array(
          [$instance, $method],
          $arguments
        );
    }
  }


  protected static function getFacadeException($method, $arguments)
  {
    return new Exception(
      sprintf(
        'Call to undefined method "%1$s" on class "%2$s" with arguments "%3$s"',
        $method,
        get_class(),
        json_encode($arguments)
      )
    );
  }
}
