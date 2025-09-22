<?php

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

  public $table = 'attendance';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }

  public function worker()
  {
    return $this->belongsTo('Worker', 'worker_id', 'id');
  }

  public function getDateAttribute($value)
  {
    if (!$value) return $value;

    if (Session::has('admin_id')) {
      $user = User::find(Session::get('admin_id', 0));
    } else {
      $user = User::find(Session::get('user_id', 0));
    }
    return Timezone::toLocal($value, $user->tz_offset, 'Y-m-d');
  }

  public function getInTimeAttribute($value)
  {
    if (!$value) return $value;

    if (Session::has('admin_id')) {
      $user = User::find(Session::get('admin_id', 0));
    } else {
      $user = User::find(Session::get('user_id', 0));
    }
    return Timezone::toLocal($value, $user->tz_offset, 'H:i:s');
  }

  public function getOutTimeAttribute($value)
  {
    if (!$value) return $value;

    if (Session::has('admin_id')) {
      $user = User::find(Session::get('admin_id', 0));
    } else {
      $user = User::find(Session::get('user_id', 0));
    }
    return Timezone::toLocal($value, $user->tz_offset, 'H:i:s');
  }
}
