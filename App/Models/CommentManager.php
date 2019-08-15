<?php

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
   * Get list of checked comment only
   * (Currently gets all comments for prod)
   *
   * @param  int $idArticle Article id
   * @param  string Type of comment (all -null-, checked, unchecked)
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



}
