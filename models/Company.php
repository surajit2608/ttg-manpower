<?php

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

  public $table = 'companies';
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
