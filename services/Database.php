<?php


class Database extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Database');
  }
}
