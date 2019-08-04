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


  public static function showAll() :array
  {
    $data = Database::setPDO()->query('SELECT * FROM articles');
    $data->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $response = $data->fetchAll();
    return $response;
  }

  public static function showOne($param) :Post
  {
    $data = Database::setPDO()->prepare("SELECT * FROM articles WHERE id = :id");
    $data->execute([
      'id' => $param
    ]);
    $data->setFetchMode(PDO::FETCH_CLASS, Post::class);
    $response = $data->fetch();
    return $response;
  }

}
