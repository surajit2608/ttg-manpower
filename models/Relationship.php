<?php

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{

  public $table = 'relationships';
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
