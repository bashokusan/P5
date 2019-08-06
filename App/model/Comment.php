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
  private $publish_date;

  // Getters

  public function getId(){
    return $this->id;
  }

  public function getIdArticle(){
    return $this->id_article;
  }

  public function getAuthor(){
    return "<p>" . $this->author . "</p>";
  }

  public function getComment(){
    return "<p>" . $this->comment . "</p>";
  }

  public function getPublishDate(){
    return "<p><em>le " . $this->publish_date . "</em></p>";
  }



}
