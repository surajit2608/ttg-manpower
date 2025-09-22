<?php

namespace Core;

use Rakit\Validation\Validator;

class Input
{

  private $inputs;
  private $validator;

  public function all()
  {
    return $this->getInputs();
  }

  public function has($key)
  {
    $inputs = $this->getInputs();

    if (isset($inputs[$key])) {
      return true;
    }

    return false;
  }

  public function get($key, $default = null)
  {
    $inputs = $this->getInputs();

    if (!isset($inputs[$key])) {
      return $default;
    }

    if (is_array($inputs[$key])) {
      return $inputs[$key];
    }

    if (is_object($inputs[$key])) {
      return $inputs[$key];
    }

    return trim($inputs[$key]);
  }

  public function clean($key, $default = null)
  {
    $value = $this->get($key, $default);
    $value = preg_replace("/[\r\n]{2,}/", "\n\n", $value);
    $value = trim($value, "\n");

    return $value;
  }

  public function set($key, $value)
  {
    $this->getInputs();
    $this->inputs[$key] = $value;
  }

  public function base64($key)
  {
    $inputs = $this->getInputs();

    if (!isset($inputs[$key]))
      return false;

    if (isset($inputs['base64_' . $key]))
      return $inputs['base64_' . $key];

    $base64_key = base64_decode($inputs[$key] . '==');
    $this->inputs['base64_' . $key] = base64_decode($base64_key);

    return $this->inputs['base64_' . $key];
  }

  public function validate($rules, $messages = [])
  {
    $inputs = $this->getInputs();
    $validator = $this->getValidator();
    $validation = $validator->make($inputs, $rules);
    $validation->setMessages($messages);
    $validation->validate();
    if ($validation->fails()) {
      $errors = $validation->errors();
      return $errors->all();
    }
    return false;
  }

  private function getInputs()
  {
    if ($this->inputs)
      return $this->inputs;

    $json = file_get_contents('php://input');
    $json = $json ? $json : '{}';
    $json = json_decode($json, true);
    if (!$json) {
      $json = [];
    }
    $files = [];
    foreach ($_FILES as $key => $file) {
      if (!$file['name']) {
        continue;
      }
      $files[$key] = (object)[
        'name' => $file['name'],
        'size' => $file['size'],
        'type' => $file['type'],
        'path' => $file['tmp_name'],
      ];
    }
    $this->inputs = array_merge($_GET, $_POST, $files, $json);
    return $this->inputs;
  }

  private function getValidator()
  {
    if ($this->validator)
      return $this->validator;
    $this->validator = new Validator;
    return $this->validator;
  }

  public function headers($key = null)
  {
    $headers = apache_request_headers();
    if (!$key) return $headers;
    return $headers[$key] ?? null;
  }
}
