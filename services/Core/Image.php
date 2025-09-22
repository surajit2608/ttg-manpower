<?php

namespace Core;

class Image
{

  public function load($filename, $new_type = 'jpeg')
  {
    $new_type = strtolower($new_type);
    if (in_array($new_type, ['jpeg', 'jpg'])) {
      $image = imagecreatefromjpeg($filename);
    } elseif ($new_type == 'png') {
      $image = imagecreatefrompng($filename);
    } elseif ($new_type == 'gif') {
      $image = imagecreatefromgif($filename);
    }
    return $image;
  }

  public function resize($new_width, $new_height, $image, $width, $height)
  {
    $new_image = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    return $new_image;
  }

  public function resize_to_width($new_width, $image, $width, $height)
  {
    $ratio = $new_width / $width;
    $new_height = $height * $ratio;
    return $this->resize($new_width, $new_height, $image, $width, $height);
  }

  public function resize_to_height($new_height, $image, $width, $height)
  {
    $ratio = $new_height / $height;
    $new_width = $width * $ratio;
    return $this->resize($new_width, $new_height, $image, $width, $height);
  }

  public function scale($scale, $image, $width, $height)
  {
    $new_width = $width * $scale;
    $new_height = $height * $scale;
    return $this->resize($new_width, $new_height, $image, $width, $height);
  }

  public function save($new_image, $new_filename, $new_type = 'jpeg', $quality = 80)
  {
    $new_type = strtolower($new_type);
    if (in_array($new_type, ['jpeg', 'jpg'])) {
      imagejpeg($new_image, $new_filename, $quality);
    } elseif ($new_type == 'png') {
      imagepng($new_image, $new_filename);
    } elseif ($new_type == 'gif') {
      imagegif($new_image, $new_filename);
    }
  }
}
