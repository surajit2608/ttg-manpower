<?php

class Schema extends Facade
{

  protected static function getFacadeInstance()
  {
    return $GLOBALS['schema'];
  }
}
