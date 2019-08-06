<?php

namespace App\model;

use PDO;
use App\Database;
use App\model\Comment;

/**
 * [CommentManager]
 */
class CommentManager
{
  /**
   * Pour afficher les commentaires d'un article
   * @param  [string] $param L'id de l'article
   * @return [Objet Comment]
   */
  public static function showAll($param)
  {
    $query = Database::setPDO()->prepare("SELECT * FROM comments WHERE id_article = :id");
    $query->execute([
      'id' => $param
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS, Comment::class);
    $response = $query->fetchAll();
    return $response;

    $query->closeCursor();
  }
}
