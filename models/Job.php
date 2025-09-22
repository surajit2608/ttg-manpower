<?php

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

  public $table = 'jobs';
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
