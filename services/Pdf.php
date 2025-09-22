<?php


class Pdf extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Pdf');
  }
}
