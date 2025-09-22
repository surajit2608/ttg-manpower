<?php

$adminId = Session::get('admin_id', 0);
$me = User::find($adminId);

RESPONSE:
return [
  'me' => $me,
];
