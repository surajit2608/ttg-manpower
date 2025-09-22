<?php

use Illuminate\Database\Eloquent\Model;

class WorkerEmploymentReference extends Model
{

  public $table = 'workers_employments_references';
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
