<?php

use Illuminate\Database\Eloquent\Model;

class WorkerPayroll extends Model
{

  public $table = 'workers_payrolls';
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
