<?php


class Crypto extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Crypto');
  }
}
