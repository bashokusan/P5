<?php

namespace App\Controllers;

use PDO;

/**
 * Call Database
 */
class DBFactory
{

  /**
   * Call PDO
   */
    public static function getPDO()
    {
        $db = new PDO("mysql:host=127.0.0.1; dbname=miniblog", "root", "root", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $db;
    }
}
