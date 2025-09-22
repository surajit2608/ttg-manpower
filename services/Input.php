<?php

class Input extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Input');
  }
}
