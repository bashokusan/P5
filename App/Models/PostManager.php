<?php
/**
 * PostManager
 */
class PostManager
{

  private $db;

  public function __construct(PDO $db)
  {
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->db = $db;
  }

  public function getList($limit, $offset)
  {
    $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $query = $this->db->query($sql);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Post::class);
    $postList= $query->fetchAll();

    $query->closeCursor();
    return $postList;
  }

  public function getUnique($id)
  {
    $sql = "SELECT * FROM articles WHERE id = :id";
    $query = $this->db->prepare($sql);
    $query->execute([
      'id' => $id
    ]);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Post::class);
    $post = $query->fetch();

    return $post;
  }

  public function count()
  {
      return $this->db->query('SELECT COUNT(*) FROM articles')->fetchColumn();
  }

}
