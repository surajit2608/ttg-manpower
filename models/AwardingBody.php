<?php

use Illuminate\Database\Eloquent\Model;

class AwardingBody extends Model
{

  public $table = 'awarding_bodies';
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
