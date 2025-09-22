<?php


class Notify extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Module\Notify');
  }
}
