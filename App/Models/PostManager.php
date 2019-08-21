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
   * Last action before sending post
   *
   * @param  Post $post Validated post object
   */
  public function save(Post $post)
  {
    if($post->isNew())
    {
      $this->add($post);
    }
    else
    {
      $this->update($post);
    }
  }



  /**
   * Add new post in the database
   * @param post $post Post object created after form submit
   */
  public function add(Post $post)
  {
    $sql = "INSERT INTO articles(idauthor, image, title, kicker, content, publishDate)
            VALUES(:idauthor, image, :title, :kicker, :content, NOW())";
    $query = $this->db->prepare($sql);
    $query->execute([
      'idauthor' => $post->idauthor(),
      'image' => $post->image(),
      'title' => $post->title(),
      'kicker' => $post->kicker(),
      'content' => $post->content()
    ]);
  }


  /**
   * [update description]
   * @param  Post   $post [description]
   */
  public function update(Post $post)
  {
    $sql = "UPDATE articles SET idauthor = :idauthor, image = :image, title = :title, kicker = :kicker, content = :content, updateDate = NOW()
            WHERE id = :id";
    $query = $this->db->prepare($sql);
    $query->execute([
      'idauthor' => $post->idauthor(),
      'image' => $post->image(),
      'title' => $post->title(),
      'kicker' => $post->kicker(),
      'content' => $post->content(),
      'id' => $post->id()
    ]);
  }


  /**
   * Get all posts from database
   * @param  int $limit  (see pagination in FrontendController blog())
   * @param  int $offset (see pagination in FrontendController blog())
   * @return Post
   */
  public function getList($limit = null, $offset = null)
  {
    $sql = "SELECT articles.id, articles.image, articles.title, articles.kicker, articles.content, articles.publishDate, articles.updateDate, articles.countComment, users.name FROM articles JOIN users ON articles.idauthor = users.id ORDER BY articles.id DESC ";
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
    $sql = "SELECT articles.id, articles.image, articles.title, articles.kicker, articles.content, articles.publishDate, articles.updateDate, articles.countComment, users.name FROM articles JOIN users ON articles.idauthor = users.id WHERE articles.id = :id";
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
