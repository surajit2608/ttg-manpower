<?php


class Address extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Module\Address');
  }
}
