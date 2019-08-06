<?php

namespace App\model;

/**
 * Class Comment
 * Describe a comment
 */
class Comment
{

  private $id;
  private $id_article;
  private $author;
  private $comment;
  private $date;

  // Getters

  public function getId(){
    return $this->id;
  }

  public function getIdArticle(){
    return $this->id_article;
  }

  public function getAuthor(){
    return $this->author;
  }

  public function getComment(){
    return $this->comment;
  }

  public function getDate(){
    return $this->date;
  }



}
