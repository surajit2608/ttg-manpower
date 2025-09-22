<?php

function get_log_files($dir, &$results = array())
{
  $files = scandir($dir);
  $dirs_list = [];
  $files_list = [];

  if ($files) {
    foreach ($files as $key => $value) {
      $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
      if (!is_dir($path)) {
        $files_list[] = $path;
      } elseif ($value != "." && $value != "..") {
        $dirs_list[] = $path;
      }
    }
    rsort($files_list);
    foreach ($files_list as $path) {
      preg_match("/^.*\/(\S+)$/", $path, $matches);
      $name = str_replace($dir . DIRECTORY_SEPARATOR, '', $path);
      $results[$name] = array('name' => $name, 'path' => $path);
    }
    if (count($dirs_list) > 0) {
      foreach ($dirs_list as $path) {
        get_log_files($path, $results);
      }
    }
    return $results;
  }

  return;
}

function tail($filename, $lines = 50, $buffer = 4096)
{
  $filename = LOGS_DIR . '/' . $filename;
  if (!is_file($filename)) {
    return;
  }
  $f = fopen($filename, "rb");
  if (!$f) {
    return;
  }

  fseek($f, -1, SEEK_END);

  if (fread($f, 1) != "\n") $lines -= 1;

  $output = '';
  $chunk = '';

  while (ftell($f) > 0 && $lines >= 0) {
    $seek = min(ftell($f), $buffer);
    fseek($f, -$seek, SEEK_CUR);
    $output = ($chunk = fread($f, $seek)) . $output;
    fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);
    $lines -= substr_count($chunk, "\n");
  }

  while ($lines++ < 0) {
    $output = substr($output, strpos($output, "\n") + 1);
  }
  $output = str_replace(['[', ']', ','], "<br>", $output);
  fclose($f);
  return $output;
}


function getFileNames($files, $lines = 50)
{
  global $log;

  if (empty($files)) {
    return;
  }
  if (!isset($log))
    $log = 0;
  $file_names = [];
  foreach ($files as $dir => $files_array) {
    if (!is_file($files_array['path'])) {
      unset($files_array[$k]);
      continue;
    }
    $page = str_replace(LOGS_DIR . '/', '', $log);

    $file_names[] = $files_array['name'];
  }
  return $file_names;
}

$log = 0;
$lines = $_GET['lines'] ?? 50;
$files = get_log_files(LOGS_DIR);
$fileNames = getFileNames($files, $lines);
$index = $_GET['file_index'] ?? $fileNames[0];
$log = urldecode($files[$index]['path']);
$filename = str_replace(LOGS_DIR . '/', '', $log);
$errors = tail($filename, $lines);
$errors = explode("\n", $errors);
$errors = array_reverse($errors);
$errors = array_filter($errors);
$output = [
  'selected_file' => $filename,
  'files' => $fileNames,
  'errors' => $errors
];

header('Content-Type: application/json');
echo json_encode($output);
exit;
