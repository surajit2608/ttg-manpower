<?php


class Pagination extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Pagination');
  }
}
