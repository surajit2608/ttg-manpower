<?php

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

  public $table = 'roles';
  public $timestamps = false;

  public function getPermissionsAttribute($value)
  {
    return json_decode($value);
  }

  public function setPermissionsAttribute($value)
  {
    $this->attributes['permissions'] = json_encode($value);
  }

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }
}
