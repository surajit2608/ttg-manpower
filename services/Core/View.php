<?php

namespace Core;

use Windwalker\Edge\Edge;
use Windwalker\Edge\Cache\EdgeFileCache;
use Windwalker\Edge\Compiler\EdgeCompiler;
use Windwalker\Edge\Loader\EdgeFileLoader;
use Windwalker\Edge\Loader\EdgeStringLoader;

class View
{

  public $view;
  public $htmlView;

  public function get($page, $data = [])
  {
    return $this->render($page, $data);
  }

  public function render($page, $data = [])
  {
    $page = str_replace('.', '/', $page);

    $viewFiles = [
      SECTION . '/pages',
      SECTION . '/partials',
      SECTION . '/templates',
      APP_DIR . '/utilities',
      UPLOAD_DIR . '/embeds',
    ];

    $fileNotFound = true;
    foreach ($viewFiles as $viewFile) {
      if (file_exists($viewFile . '/' . $page . '.php')) {
        $fileNotFound = false;
        break;
      }
    }

    if ($fileNotFound) {
      $page = '404';
      $viewFiles = [
        APP_DIR . '/errors'
      ];
    }

    $view = $this->getInstance($viewFiles);
    return $view->render($page, $data);
  }

  public function getInstance($viewFiles)
  {
    if ($this->view) {
      return $this->view;
    }

    $loader = new EdgeFileLoader($viewFiles);
    $loader->addFileExtension('.php');

    $compiler = new EdgeCompiler;
    $compiler->setRawTags('<%%', '%%>');
    $compiler->setContentTags('<%', '%>');
    $compiler->setEscapedContentTags('<%%', '%%>');

    $cacheLoader = new EdgeFileCache(STORAGE_DIR . '/views');
    $this->view = new Edge($loader, $compiler, $cacheLoader);

    return $this->view;
  }

  public function compile($html, $data = [])
  {
    if ($this->htmlView) {
      $view = $this->htmlView;
    } else {

      $loader = new EdgeStringLoader;
      $compiler = new EdgeCompiler;
      $compiler->setRawTags('<%', '%>');
      $compiler->setContentTags('{', '}');
      $compiler->setEscapedContentTags('<%%', '%%>');

      $view = new Edge($loader, $compiler);
      $this->htmlView = $view;
    }
    return $view->render($html, $data);
  }
}
