<?php

use Illuminate\Database\Eloquent\Model;

class WorkerHealth extends Model
{

  public $table = 'workers_healths';
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
