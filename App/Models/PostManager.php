<?php

/**
 * Manage post
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

  /**
   * Get all posts from database
   * @param  int $limit  (see pagination in FrontendController blog())
   * @param  int $offset (see pagination in FrontendController blog())
   * @return Post
   */
  public function getList($limit = null, $offset = null)
  {
    $sql = "SELECT * FROM articles ORDER BY id DESC ";
    if(isset($limit) && isset($offset)){
      $sql .= "LIMIT $limit OFFSET $offset";
    }
    $query = $this->db->query($sql);
    $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Post::class);
    $postList= $query->fetchAll();

    $query->closeCursor();
    return $postList;
  }


  /**
   * Get one post
   * @param  int $id Article id
   * @return Post
   */
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

  public function delete ($id)
  {
    $sql = "DELETE FROM comments WHERE idArticle =".(int)$id;
    $this->db->exec($sql);

    $sql = "DELETE FROM articles WHERE id=".(int)$id;
    $this->db->exec($sql);
  }

}
