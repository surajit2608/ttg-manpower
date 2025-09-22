<?php

$files = glob(STORAGE_DIR . '/views/*');
foreach ($files as $file) {
  if (is_file($file))
    @unlink($file);
}

echo "Views Cleard.";
