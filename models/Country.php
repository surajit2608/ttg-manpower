<?php

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

  public $table = 'countries';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }
}
