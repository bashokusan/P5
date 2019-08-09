<?php

namespace App\Model;

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
    $query = Database::setPDO()->prepare("SELECT * FROM comments WHERE id_article = :id ORDER BY publish_date DESC");
    $query->execute([
      'id' => $param
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS, Comment::class);
    $response = $query->fetchAll();
    return $response;

    $query->closeCursor();
  }

  public static function countComment($param)
  {
    $query = Database::setPDO()->prepare("SELECT count(id) FROM comments WHERE id_article = :id");
    $query->execute([
      'id' => $param
    ]);;
    $countComment = $query->fetch();
    return $countComment;

    $query->closeCursor();
  }

  /**
   * Pour insérer un commentaire en BDD
   * @param  string $author  $_GET['author']
   * @param  string $comment $_GET['comment']
   * @param  int    $id      id du post
   * @return bool          retourne true si le commentaire est bien enregistré.
   */
  public static function postComment(string $author, string $comment, int $id) :bool
  {
    $query = Database::setPDO()->prepare("INSERT INTO comments (id_article, author, comment, publish_date)
                                          VALUES(:id_article, :author, :comment, NOW()) ");
    $response = $query->execute([
                                  'id_article' => $id,
                                  'author' => $author,
                                  'comment' => $comment
                                ]);
    return $response;
  }
}
