<?php

$data = false;
$events = false;

$files = [];

$fileName = Input::get('filename', time());
$filePath = Input::get('filepath', 'files');

$url = UPLOAD_URL . '/' . $filePath;
$path = UPLOAD_DIR . '/' . $filePath;

if (!file_exists($path)) {
  mkdir($path, 0777, true);
}

foreach ($_FILES as $file) {
  if ($file['error'] > 0) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => $file['error'],
      ],
    ];
    goto RESPONSE;
  }

  if ($file['name'] == 'blob') {
    $ext = 'png';
  } else {
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
  }

  $filename = $fileName . '-' . uniqid() . '.' . strtolower($ext);

  $upload = move_uploaded_file($file['tmp_name'], $path . '/' . $filename);
  if (!$upload) {
    $events = [
      'message.show' => [
        'type' => 'error',
        'text' => 'Error while uploading the file',
      ],
    ];
    goto RESPONSE;
  }

  $files[] = [
    'name' => $filename,
    'original' => $file['name'],
    'url' => $url . '/' . $filename,
    'path' => $path . '/' . $filename,
  ];
}

$data = [
  'files' => $files,
];

RESPONSE:
return [
  'data' => $data,
  'events' => $events
];
