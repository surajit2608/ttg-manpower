<?php


class Route extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Route');
  }
}
