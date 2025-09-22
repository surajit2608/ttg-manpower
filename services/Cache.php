<?php


class Cache extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Cache');
  }
}
