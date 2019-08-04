<?php

namespace App;

use PDO;
use App\Database;

/**
 * Class Post
 * Describe a post
 */
class Post
{

  private $id;
  private $title;
  private $kicker;
  private $content;
  private $publish_date;
  private $update_date;

  // Getters

  public function getId(){
    return $this->id;
  }

  public function getTitle(){
    return $this->title;
  }

  public function getKicker(){
    return $this->kicker;
  }

  public function getContent(){
    return $this->content;
  }

  public function getPublishDate(){
    return $this->publish_date;
  }

  public function getUpdateDate(){
    return $this->update_date;
  }

  public static function count()
  {
    $query = Database::setPDO()->query('SELECT count(id) FROM articles');
    $count = $query->fetch();
    return $count;
    
    $query->closeCursor();
  }

  public static function showAll() :array
  {
    $query = Database::setPDO()->query('SELECT * FROM articles');
    $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $response = $query->fetchAll();
    return $response;

    $query->closeCursor();
  }

  public static function showOne($param) :Post
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
