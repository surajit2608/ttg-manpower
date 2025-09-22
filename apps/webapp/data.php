<?php

$userId = Session::get('user_id', 0);
$me = Worker::find($userId);

RESPONSE:
return [
  'me' => $me,
];
