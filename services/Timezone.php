<?php


class Timezone extends Facade
{

  protected static function getFacadeInstance()
  {
    return Load('Core\Timezone');
  }
}
