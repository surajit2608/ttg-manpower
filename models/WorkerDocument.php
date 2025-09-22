<?php

use Illuminate\Database\Eloquent\Model;

class WorkerDocument extends Model
{

  public $table = 'workers_documents';
  public $timestamps = false;

  public function getDetailsAttribute($value)
  {
    return json_decode($value);
  }

  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = json_encode($value);
  }


  public function document_type()
  {
    return $this->belongsTo('DocumentType', 'document_type_id', 'id');
  }
}
