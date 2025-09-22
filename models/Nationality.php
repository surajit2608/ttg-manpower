<?php

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{

  public $table = 'nationalities';
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
