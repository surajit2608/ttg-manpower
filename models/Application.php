<?php

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

  public $table = 'applications';
  public $timestamps = false;
  protected $appends = [];

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function job()
  {
    return $this->belongsTo('Job', 'job_id', 'id');
  }

  public function client()
  {
    return $this->belongsTo('Client', 'client_id', 'id');
  }
}
