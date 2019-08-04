<?php

namespace App;

use PDO;

/**
 * Class Database
 * Call PDO
 */
class Database
{

  public static function setPDO() :PDO
  {
    $pdo = new PDO("mysql:host=127.0.0.1; dbname=miniblog", "root", "root", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    return $pdo;
  }

}
