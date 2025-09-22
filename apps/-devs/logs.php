<?php

if (isset($_POST['path'])) {
  $path = $_POST['path'];

  if (@unlink(LOGS_DIR . '/' . $path)) {
    $status['code'] = 0;
  } else {
    $status['code'] = 1;
  }

  echo json_encode($status);
  exit();
}


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
      $results[$dir][$name] = array('name' => $name, 'path' => $path);
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


function show_list_of_files($files, $lines = 50)
{
  global $log;

  if (empty($files)) {
    return;
  }
  if (!isset($log))
    $log = 0;

  foreach ($files as $dir => $files_array) {
    foreach ($files_array as $k => $f) {
      if (!is_file($f['path'])) {
        unset($files_array[$k]);
        continue;
      }

      $page = str_replace(LOGS_DIR . '/', '', $log);
      $fileName = basename($f['name']);

      $active = ($fileName == $page) ? 'list-group-item-warning' : '';
      echo '<li class="list-group-item justify-content-between ' . $active . '">';
      echo '<a href="' . SITE_URL . '/-dev/logs/?p=' . urlencode($fileName) . '&lines=' . $lines . '">' . $fileName . '</a>';
      echo '<span style="cursor:pointer" onClick="trashLogFile(\'' . $fileName . '\')" class="badge badge-danger badge-pill">x</span>';
      echo '</li>';
    }
  }
}


$log = (!isset($_GET['p'])) ? 0 : LOGS_DIR . '/' . urldecode($_GET['p']);
$lines = (!isset($_GET['lines'])) ? 50 : $_GET['lines'];
$files = get_log_files(LOGS_DIR);

$filename = $log;
$title = substr($log, (strrpos($log, '/') + 1));

$page_name = 'Error Logs';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/flexboxgrid.min.css" />
  <title>Error Logs</title>
  <style media="screen">
    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-size: 16px;
      overflow: hidden;
      font-family: sans-serif;
    }

    .controls {
      font-size: 1rem;
      border-radius: 0.25rem;
      box-sizing: border-box;
      background-color: #fff;
      padding: 0.5rem 0.75rem;
      border: 1px solid #dddddd;
      transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .layout {
      height: 100%;
    }

    .main {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .header {
      z-index: 9;
      display: flex;
      padding: 1rem;
      position: relative;
      flex-direction: column;
      justify-content: center;
      box-shadow: 0 4px 4px -2px rgba(0, 0, 0, 0.1);
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .header .row {
      align-items: center;
    }

    .left-header {
      margin: 0;
      font-size: 2rem;
      overflow: hidden;
      font-weight: normal;
      white-space: nowrap;
      font-family: Constantia;
      text-overflow: ellipsis;
    }

    #clock-utc {
      color: #fff;
      display: flex;
      padding: 0.5rem;
      align-self: center;
      background: #0275d8;
      border-radius: 0.25rem;
      justify-content: center;
    }

    .content {
      flex: 1;
      padding: 1rem;
      display: flex;
      overflow-y: auto;
      overflow-x: hidden;
      flex-direction: column;
    }

    .jumbotron {
      padding: 4rem 2rem;
      border-radius: 0.25rem;
      font-family: Constantia;
      background-color: #eceeef;
    }

    .jumbotron h1 {
      margin: 2rem 0;
      font-weight: 300;
      font-size: 4.5rem;
    }

    .jumbotron p {
      font-weight: 300;
      font-size: 1.25rem;
      margin-bottom: 3rem;
    }

    .list-group {
      top: 0;
      display: flex;
      margin: 0 0 1rem;
      list-style: none;
      overflow: hidden;
      position: sticky;
      padding: 0 0 1px 0;
      border-radius: 0.25rem;
      flex-direction: column;
    }

    .list-group-item {
      display: flex;
      flex-flow: row wrap;
      align-items: center;
      margin-bottom: -1px;
      padding: 0.75rem 1rem;
      background-color: #fff;
      border: 1px #dddddd;
    }

    .list-group-item:last-child {
      border-radius: 0 0 0.25rem 0.25rem;
    }

    .list-group-item.active {
      color: #fff;
      border-color: #0275d8;
      background-color: #0275d8;
    }

    code {
      font-size: 90%;
      padding: 0.25rem;
      margin-bottom: 0.25rem;
      border-radius: 0.25rem;
      background-color: #f7f7f9;
    }

    code.info {
      color: #aba000;
    }

    code.error {
      color: #bd4147;
    }

    code .list-group-item {
      border-radius: 0.25rem !important;
    }

    .justify-content-between {
      justify-content: space-between !important;
    }

    .badge {
      color: #fff;
      font-size: 75%;
      padding: 0.25em;
      font-weight: 700;
      text-align: center;
      white-space: nowrap;
      display: inline-block;
      border-radius: 0.25rem;
      vertical-align: baseline;
    }

    .badge-danger {
      background-color: #d9534f;
    }

    .badge-pill {
      padding-left: 0.5em;
      padding-right: 0.5em;
      border-radius: 10rem;
    }
  </style>
</head>

<body>
  <div class="layout">
    <div class="main">
      <div class="header">
        <div class="row">
          <div class="col-sm-3">
            <h1 class="left-header"><?php echo !empty($title) ? $title : $page_name; ?></h1>
          </div>
          <div class="col-sm-3">
            <div id="clock-utc"></div>
          </div>
          <div class="col-sm-2"></div>
          <div class="col-sm-4 end-sm">
            <form method="get">
              <input type="hidden" name="p" value="<?php echo str_replace(LOGS_DIR . '/', '', $log); ?>">
              <label>
                How many lines to display?
                <select class="controls" name="lines" onChange="this.form.submit()">
                  <option value="10" <?php echo ($lines == '10') ? 'selected' : ''; ?>>10</option>
                  <option value="50" <?php echo ($lines == '50') ? 'selected' : ''; ?>>50</option>
                  <option value="100" <?php echo ($lines == '100') ? 'selected' : ''; ?>>100</option>
                  <option value="500" <?php echo ($lines == '500') ? 'selected' : ''; ?>>500</option>
                  <option value="1000" <?php echo ($lines == '1000') ? 'selected' : ''; ?>>1000</option>
                </select>
              </label>
            </form>
          </div>
        </div>
      </div>

      <div class="content">
        <div class="row">
          <div class="col-sm-3">
            <ul class="list-group">
              <a href="<?= SITE_URL ?>/-dev/logs/" class="list-group-item active">Log Dates</a>
              <?php show_list_of_files($files, $lines); ?>
            </ul>
          </div>

          <div class="col-sm-9">

            <?php
            $output = tail($filename, $lines);
            if ($output) :
              $output = explode("\n", $output);
              $output = array_reverse($output);
            ?>

              <ul class="list-group">
                <?php foreach ($output as $out) : ?>
                  <?php if (strpos($out, 'LOGS.INFO') == false) : ?>
                    <code class="error">
                      <li class="list-group-item"><?= $out ?></li>
                    </code>
                  <?php else : ?>
                    <code class="info">
                      <li class="list-group-item"><?= $out ?></li>
                    </code>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>

            <?php else : ?>

              <div class="jumbotron">
                <h1>Error Logs</h1>
                <p>Choose Log Date from the list to view error logs.</p>
              </div>

            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function renderTime() {
      var dd = new Date();
      var a = "AM";
      var y = dd.getUTCFullYear();
      var m = dd.getUTCMonth() + 1;
      var d = dd.getUTCDate();
      var h = dd.getUTCHours();
      var i = dd.getUTCMinutes();
      var s = dd.getUTCSeconds();

      h = (h == 0) ? 12 : h;
      h = (h < 10) ? '0' + h : h;
      i = (i < 10) ? '0' + i : i;
      s = (s < 10) ? '0' + s : s;
      m = (m < 10) ? '0' + m : m;
      d = (d < 10) ? '0' + d : d;

      var myclock = document.getElementById('clock-utc');
      myclock.innerHTML = 'GMT+00:00 ' + y + "-" + m + "-" + d + " " + h + ":" + i + ":" + s;
      setTimeout('renderTime()', 1000);
    }

    renderTime();

    setInterval(renderTime, 1000);

    var $devUrl = "<?= DEV_URL ?>";

    function trashLogFile(path) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', $devUrl + '/logs');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          window.location.href = $devUrl + '/logs';
        }
      };
      xhr.send(encodeURI('path=' + path));
    }
  </script>
</body>

</html>