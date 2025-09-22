<?php


class Image extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Image');
  }
}
