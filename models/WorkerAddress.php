<?php

use Illuminate\Database\Eloquent\Model;

class WorkerAddress extends Model
{

  public $table = 'workers_addresses';
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
