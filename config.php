<?php

// App Database Connection
$capsule = Database::connect(DB_NAME);
try {
  DB::connection()->getPdo();
} catch (Exception $e) {
  include BASE_DIR . '/apps/errors/500.php';
  exit;
}
$schema =  $capsule->schema();

if (DEBUG) {
  DB::enableQueryLog();
}
