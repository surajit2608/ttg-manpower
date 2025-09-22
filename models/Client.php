<?php

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

  public $table = 'clients';
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
