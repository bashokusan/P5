<?php

namespace App\Models;
use App\Models\Comment;
use PDO;

/**
 * Manage comments
 */
class CommentManager
{

  private $db;

  public function __construct(PDO $db)
  {
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->db = $db;
  }

  /**
   * Last action before sending comment
   * More to be added (switch case between add and update)
   *
   * @param  Comment $comment Validated comment object
   */
  public function save(Comment $comment)
  {

      $this->add($comment);

  }



  /**
   * Get list of comments with type (unchecked or checked)
   * No article id needed
   */
  public function getListNoId($type = null)
  {
    $sql = "SELECT * FROM comments ";

    switch ($type) {
      case 'checked':
        $and = " WHERE checked = 1 ";
        break;
      case 'flag':
        $and = " WHERE checked = 2 ";;
        break;
      case 'unchecked':
        $and = " WHERE checked = 0 ";;
        break;
      default:
        $and = " ";
        break;
    }


    $sql .= $and;
    $sql .= "ORDER BY publishDate DESC";
    $query = $this->db->query($sql);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Comment::class);
    $commentList = $query->fetchAll();

    $query->closeCursor();
    return $commentList;
  }


  /**
   * Get list of checked comment only
   *
   */
  public function getList($idArticle, $type = null)
  {
    switch ($type) {
      case 'checked':
        $and = " AND checked = 1 ";
        break;
      case 'unchecked':
        $and = " AND checked = 0 ";;
        break;
      default:
        $and = " ";
        break;
    }
    $sql = "SELECT * FROM comments WHERE idArticle = :idArticle";
    $sql .= $and;
    $sql .= "ORDER BY publishDate DESC";
    $query = $this->db->prepare($sql);
    $query->execute([
      'idArticle' => $idArticle
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Comment::class);
    $commentList = $query->fetchAll();

    $query->closeCursor();
    return $commentList;
  }

  /**
   * Add new comment in the database
   * Update comment counter for the article
   *
   * @param Comment $comment Comment object created after form submit
   */
  public function add(Comment $comment)
  {
    $sql = "INSERT INTO comments(idArticle, author, content, publishDate)
            VALUES(:idArticle, :author, :content, NOW())";
    $query = $this->db->prepare($sql);
    $query->execute([
      'idArticle'  => $comment->idArticle(),
      'author' => $comment->author(),
      'content' => $comment->content()
    ]);
  }


  /**
   * Count comments by type and article id
   * @param  string $type Type of comments (checked is 1, unchecked is 0)
   * @param  int $id   Id of article
   */
  public function count($type = null, $id = null)
  {
    $sql = "SELECT COUNT(*) FROM comments ";
    switch ($type) {
      case 'checked':
        $sql .=  "WHERE checked = 1";
        break;
      case 'flag':
        $sql .=  "WHERE checked = 2";
        break;
      case 'unchecked':
        $sql .=  "WHERE checked = 0";;
        break;
      default:
        $sql .=  " ";
        break;
    }
    if($id)
    {
      $sql .= " AND idArticle =".$id;
    }
    return $this->db->query($sql)->fetchColumn();
  }


  /**
   * Update comment check and increment countComment of article
   * @param  int $id        Comment id
   * @param  int $idarticle Article id
   * @param  int $type     Type of check (checked / flag)
   */
  public function updateCheck($id, $idarticle, $type)
  {
    $sql = "UPDATE comments SET checked = $type WHERE id = $id";
    $query = $this->db->exec($sql);

    if($type === 1){
      $query = $this->db->exec("UPDATE articles SET countComment = countComment + 1 WHERE id = $idarticle");
    }
  }


}
