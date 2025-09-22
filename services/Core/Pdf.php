<?php

namespace Core;

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{

  public $html = null;
  private $options = [];

  public function url($url)
  {
    $this->html = file_get_contents($url);
  }

  public function html($html)
  {
    $this->html = $html;
  }

  public function options($options)
  {
    $this->options = new Options();
    foreach ($options as $key => $value) {
      $this->options->set($key, $value);
    }
  }

  public function render($name = 'invoice.pdf', $option = [])
  {
    $option = (object)$option;
    $page = $option->page ?? 'A4';
    $download = $option->download ?? false;
    $orientation = $option->orientation ?? 'potrait';

    $dompdf = new Dompdf($this->options);
    $dompdf->loadHtml($this->html);
    $dompdf->setPaper($page, $orientation);
    $dompdf->render();
    $dompdf->stream($name, [
      'Attachment' => $download
    ]);
  }
}
