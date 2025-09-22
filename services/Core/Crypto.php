<?php

namespace Core;

class Crypto
{

  public function hash($string, $length = null, $hash = true)
  {
    $key = $hash ? HASH_KEY : null;
    $hash = sha1($string . $key);
    if ($length) {
      $hash = substr($hash, 0, $length);
    }
    return $hash;
  }

  public function password($password)
  {
    return $this->hash($password, null, false);
  }

  public function encrypt($string)
  {
    return $this->encrypt_decrypt($string, 'encrypt');
  }

  public function decrypt($string)
  {
    return $this->encrypt_decrypt($string, 'decrypt');
  }

  public function encrypt_decrypt($string, $action)
  {
    $secret_iv = 'r%fek/Yu@8q}N<[Bq';
    $secret_key = 'R7w&z7c+dR{BHRKu';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
      $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'decrypt') {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
  }
}
