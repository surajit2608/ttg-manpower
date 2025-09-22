<?php


class Console extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Console');
  }
}
