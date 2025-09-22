<?php


class Email extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Email');
  }
}
