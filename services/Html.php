<?php

class Html extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\View');
  }
}
