<?php

/**
 * [CommentManager]
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

  public function save(Comment $comment)
  {

      $this->add($comment);

  }

  public function getListChecked($idArticle)
  {
    $sql = "SELECT * FROM comments WHERE idArticle = :idArticle /*AND checked = 1*/ ORDER BY publishDate DESC";
    $query = $this->db->prepare($sql);
    $query->execute([
      'idArticle' => $idArticle
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Comment::class);
    $commentList = $query->fetchAll();

    $query->closeCursor();
    return $commentList;
  }

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

    $query = $this->db->prepare("UPDATE articles SET countComment = countComment + 1 WHERE id = :id");
    $query->execute([
                'id' => $comment->idArticle(),
              ]);
  }



}
