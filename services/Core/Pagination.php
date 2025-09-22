<?php

namespace Core;

class Pagination
{

  public function get($page, $limit, $count, $totalCount)
  {
    $left = (int)$page - 1;
    $right = (int)$page + 1;

    if ($page == 1) {
      $left = 0;
    }

    if (($totalCount <= $page * $limit)) {
      $right = 0;
    }

    if ($page == -1) {
      $page = 1;
      $left = 0;
      $right = 0;
    }

    $pages = ceil($totalCount / $limit);

    $pagination = (object)[
      'left' => (int)$left,
      'page' => (int)$page,
      'input' => (int)$page,
      'right' => (int)$right,
      'limit' => (int)$limit,
      'count' => (int)$count,
      'pages' => (int)$pages,
      'total' => (int)$totalCount,
    ];

    return $pagination;
  }
}
