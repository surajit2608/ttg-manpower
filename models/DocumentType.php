<?php

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{

  public $table = 'document_types';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }
  

  public function documents()
  {
    return $this->hasMany('WorkerDocument', 'document_type_id', 'id');
  }
}
