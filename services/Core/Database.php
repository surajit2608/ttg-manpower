<?php

namespace Core;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Capsule\Manager;

class Database
{

  public function connect($dbName)
  {

    $capsule = new Manager;

    $capsule->addConnection([
      'driver'    => 'mysql',
      'host'      => DB_HOST,
      'database'  => $dbName,
      'username'  => DB_USERNAME,
      'password'  => DB_PASSWORD,
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => DB_PREFIX,
      'strict'     => false,
    ], 'default');

    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
  }

  public function disconnect($dbName)
  {
    DB::disconnect($dbName);
  }

  public function reconnect($dbName)
  {
    Config::set('database.connections.mysql.database', $dbName);
  }
}
