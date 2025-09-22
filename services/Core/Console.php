<?php

namespace Core;

use DB;

class Console
{

  public $serverLog = [
    'LOGS' => [],
    'ERRORS' => [],
    'QUERIES' => [],
    'SESSIONS' => [],
    'MEMORY, EXECUTION' => [],
  ];

  public function log()
  {
    $this->serverLog['LOGS'][] = func_get_args();
  }
  public function getLogs()
  {
    return json_encode($this->serverLog['LOGS']);
  }

  public function error()
  {
    $this->serverLog['ERRORS'][] = func_get_args();
  }

  public function getErrors()
  {
    return json_encode($this->serverLog['ERRORS']);
  }

  public function getServerLog()
  {

    $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
    $executionTime = number_format($executionTime, 2) . 'sec';
    $unit = ['b', 'kb', 'mb', 'gb'];
    $memoryUsed = memory_get_usage(true);
    $memoryUsed = round($memoryUsed / pow(1024, ($i = floor(log($memoryUsed, 1024)))), 2) . $unit[$i];
    $this->serverLog['MEMORY, EXECUTION'] = [[$memoryUsed . ', ' . $executionTime]];
    $this->serverLog['SESSIONS'] = [[$_SESSION ?? []]];
    $this->serverLog['QUERIES'] = [DB::getQueryLog()];

    return json_encode($this->serverLog);
  }
}
