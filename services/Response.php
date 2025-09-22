<?php


class Response extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Response');
  }
}
