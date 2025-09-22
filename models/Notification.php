<?php

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

  public $table = 'notifications';
  public $timestamps = false;
  protected $appends = [
    'ago',
    'sender',
  ];

  public function getAgoAttribute()
  {
    $periods = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
    $lengths = ["60", "60", "24", "7", "4.35", "12", "10"];

    $difference = time() - strtotime($this->created_at);

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
      $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
      $periods[$j] .= "s";
    }

    return "$difference $periods[$j] ago";
  }

  public function getSenderAttribute()
  {
    if ($this->receiver_type == 'worker') {
      $sender = User::find($this->sender_id);
    } else {
      $sender = Worker::find($this->sender_id);
    }
    return $sender;
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
