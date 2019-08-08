<?php

namespace App\Model;

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

  public function getIdArticle() :string
  {
    return $this->id_article;
  }

  public function getAuthor() :string
  {
    return "<p>" . $this->author . "</p>";
  }

  public function getComment() :string
  {
    return "<p>" . $this->comment . "</p>";
  }

  public function getPublishDate() :string
  {
    return "<p><em>le " . date("d/m/Y à H:m", strtotime($this->publish_date)) . "</em></p>";
  }



}
