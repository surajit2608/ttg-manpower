<?php

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{

  public $table = 'workers';
  public $timestamps = false;

  protected $appends = [
    'tz_name',
    'distance',
    'name_initial',
    'visa_days_left',
    'registration_date',
  ];

  public function getTzNameAttribute($value)
  {
    if ($value) return $value;

    $value = Timezone::name($this->tz_offset);
    return $value;
  }

  public function getDistanceAttribute($value)
  {
    if ($value) return $value;

    return 0;
  }

  public function getNameInitialAttribute($value)
  {
    if ($value) return $value;

    $nameParts = explode(' ', $this->account_name);
    if (isset($nameParts[0])) {
      $value .= substr($nameParts[0], 0, 1);
    }
    if (isset($nameParts[1])) {
      $value .= substr($nameParts[1], 0, 1);
    }
    if (!$value) {
      $value = '*';
    }

    return $value;
  }

  public function getVisaDaysLeftAttribute($value)
  {
    if ($value) return $value;

    $now = $visaExpiry = time();
    $basic = WorkerBasic::where('worker_id', $this->id)->first();
    if ($basic) {
      $visaExpiry = strtotime($basic->visa_expiry);
    }
    $diff = $visaExpiry - $now;
    $value = abs(round($diff / 86400));
    if ($value < 0) $value = 0;

    return $value;
  }

  public function getRegistrationDateAttribute()
  {
    return date('Y-m-d', strtotime($this->created_at));
  }

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function basic()
  {
    return $this->hasOne('WorkerBasic', 'worker_id', 'id');
  }

  public function payroll()
  {
    return $this->hasOne('WorkerPayroll', 'worker_id', 'id');
  }

  public function addresses()
  {
    return $this->hasMany('WorkerAddress', 'worker_id', 'id');
  }

  public function employments()
  {
    return $this->hasMany('WorkerEmployment', 'worker_id', 'id');
  }

  public function trainings()
  {
    return $this->hasMany('WorkerTraining', 'worker_id', 'id');
  }

  public function references()
  {
    return $this->hasMany('WorkerReference', 'worker_id', 'id');
  }

  public function health()
  {
    return $this->hasOne('WorkerHealth', 'worker_id', 'id');
  }

  public function policy()
  {
    return $this->hasOne('WorkerPolicy', 'worker_id', 'id');
  }

  public function grievances()
  {
    return $this->hasMany('WorkerGrievance', 'worker_id', 'id');
  }

  public function documents()
  {
    return $this->hasMany('WorkerDocument', 'worker_id', 'id');
  }

  public function application()
  {
    return $this->hasOne('Application', 'id', 'application_id');
  }
}
