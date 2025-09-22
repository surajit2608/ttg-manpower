<?php

$data = false;
$events = false;

$files = Input::get('files', []);

foreach ($files as $file) {
  $path = UPLOAD_DIR . '/' . $file;
  @unlink($path);
}


RESPONSE:
return [
  'data' => $data,
  'events' => $events
];
