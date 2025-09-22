<?php

use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{

  public $table = 'training_types';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function trainings()
  {
    return $this->hasMany('WorkerTraining', 'training_type_id', 'id');
  }
}
