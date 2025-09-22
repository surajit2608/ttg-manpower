<?php


class Session extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Session');
  }
}
