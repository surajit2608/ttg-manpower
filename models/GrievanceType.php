<?php

use Illuminate\Database\Eloquent\Model;

class GrievanceType extends Model
{

  public $table = 'grievance_types';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function grievances()
  {
    return $this->hasMany('WorkerGrievance', 'grievance_type_id', 'id');
  }
}
