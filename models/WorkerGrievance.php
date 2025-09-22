<?php

use Illuminate\Database\Eloquent\Model;

class WorkerGrievance extends Model
{

  public $table = 'workers_grievances';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function grievance_type()
  {
    return $this->belongsTo('GrievanceType', 'grievance_type_id', 'id');
  }
}
