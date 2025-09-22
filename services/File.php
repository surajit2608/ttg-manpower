<?php


class File extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\File');
  }
}
