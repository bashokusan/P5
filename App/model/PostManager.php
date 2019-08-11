<?php

namespace App\Model;

use PDO;
use App\Database;
use App\Model\Post;

/**
 * PostManager
 */
class PostManager
{

  /**
   * Pour compter le nombre d'articles
   * @return [le nombre d'article]
   */
  public static function count()
  {
    $query = Database::setPDO()->query('SELECT count(id) FROM articles');
    $count = $query->fetch();
    return $count;

    $query->closeCursor();
  }

  /**
   * Pour afficher tous les articles
   * @return [Objet]
   */
  public static function showAll($limit, $offset)
  {
    $query = Database::setPDO()->query("SELECT * FROM articles ORDER BY id DESC LIMIT $limit OFFSET $offset");
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $response = $query->fetchAll();
    return $response;

    $query->closeCursor();
  }

  /**
   * Pour afficher un article
   * @param  [string] $param L'id de l'article
   * @return [Objet]
   */
  public static function showOne($param)
  {
    $query = Database::setPDO()->prepare("SELECT * FROM articles WHERE id = :id");
    $query->execute([
      'id' => $param
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $post= $query->fetch();
    return $post;

    $query->closeCursor();
  }

}
