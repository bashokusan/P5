<?php

namespace App\Model;

use DateTime;
use App\Model\CommentManager;

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
  private $countComment;

  // Getters

  public function getId() :int
  {
    return $this->id;
  }

  public function getTitle() : string
  {
    return htmlentities($this->title);
  }

  public function getKicker() :string
  {
    return htmlentities($this->kicker);
  }

  public function getContent() :string
  {
    return nl2br(htmlentities($this->content));
  }

  public function getPublishDate() :string
  {
    return date("d/m/Y", strtotime($this->publish_date));
  }

  public function getUpdateDate() : ?string
  {
    if($this->update_date){
      return date("d/m/Y", strtotime($this->update_date));
    }else{
      return null;
    }
  }

  public function getCountComment() :?string
  {
    $this->countComment = (int)CommentManager::countComment($this->getId())[0];
    if($this->countComment == 0)
    {
      return null;
    }
    return $this->countComment;
  }
}
