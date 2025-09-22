<?php

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{

  public $table = 'leaves';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function holiday()
  {
    return $this->belongsTo('Holiday', 'holiday_id', 'id');
  }

  public function worker()
  {
    return $this->belongsTo('Worker', 'worker_id', 'id');
  }
}
