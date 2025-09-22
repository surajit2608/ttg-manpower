<?php

echo '<pre>';
$sessions = $_SESSION ?? [];
foreach ($sessions as $key => $value) {
  echo '<b>' . $key . '</b>: ' . $value . '<br>';
}
