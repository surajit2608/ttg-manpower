<?php

namespace Core;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class File
{

  private $filesystem;

  public function read($path)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->read($path);
  }

  public function has($path)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->has($path);
  }

  public function delete($path)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->delete($path);
  }

  public function rename($from, $to)
  {
    $filesystem = $this->getFileSystem($from);
    return $filesystem->rename($from, $to);
  }

  public function copy($from, $to)
  {
    $filesystem = $this->getFileSystem($from);
    return $filesystem->copy($from, $to);
  }

  public function write($path, $contents)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->put($path, $contents);
  }

  public function mime($path)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->getMimetype($path);
  }

  public function time($path)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->getTimestamp($path);
  }

  public function size($path)
  {
    $filesystem = $this->getFileSystem($path);
    return $filesystem->getSize($path);
  }

  public function store($temp, $path)
  {
    return move_uploaded_file($temp, $path);
  }

  public function clean($path)
  {
    return array_map('unlink', array_filter((array) glob($path)));
  }

  private function getFileSystem($path)
  {
    if (!$this->filesystem) {
      $this->filesystem = new Filesystem(new Local($path));
    }
    return $this->filesystem;
  }
}
