<?php


class Request extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Request');
  }
}
