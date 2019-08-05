<?php

namespace App\model;

use PDO;
use App\Database;
use App\model\Post;

class PostManager
{

  public static function count()
  {
    $query = Database::setPDO()->query('SELECT count(id) FROM articles');
    $count = $query->fetch();
    return $count;

    $query->closeCursor();
  }

  public static function showAll()
  {
    $query = Database::setPDO()->query('SELECT * FROM articles');
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $response = $query->fetchAll();
    return $response;

    $query->closeCursor();
  }

  public static function showOne($param)
  {
    $query = Database::setPDO()->prepare("SELECT * FROM articles WHERE id = :id");
    $query->execute([
      'id' => $param
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $response = $query->fetch();
    return $response;

    $query->closeCursor();
  }

}
