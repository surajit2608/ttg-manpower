<?php

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

  public $table = 'users';
  public $timestamps = false;

  protected $appends = [
    'tz_name',
    'permission',
    'name_initial',
  ];

  public function getTzNameAttribute($value)
  {
    if ($value) return $value;

    $value = Timezone::name($this->tz_offset);
    return $value;
  }

  public function getNameInitialAttribute($value)
  {
    $initial = '';
    $nameParts = explode(' ', $this->full_name);
    if (isset($nameParts[0])) {
      $initial .= substr($nameParts[0], 0, 1);
    }
    if (isset($nameParts[1])) {
      $initial .= substr($nameParts[1], 0, 1);
    }
    if (!$initial) {
      $initial = '*';
    }

    return $initial;
  }

  public function getFullNameAttribute($value)
  {
    if ($value) return $value;

    $value = $this->first_name;
    if ($this->last_name) {
      $value .= ' ' . $this->last_name;
    }

    return $value;
  }

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }

  public function getPermissionAttribute()
  {
    $allowed = [];
    $role = Role::where('id', $this->role_id)->whereNull('deleted_at')->first();
    $permissions = $role->permissions ?? [];
    foreach ($permissions as $permission) {
      if ($permission->value == 'Allow') {
        $allowed[strtolower(str_replace(' ', '_', $permission->name))] = $permission;
      }
    }
    return $allowed;
  }
}
