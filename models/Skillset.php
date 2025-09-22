<?php

use Illuminate\Database\Eloquent\Model;

class Skillset extends Model
{

  public $table = 'skillsets';
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
