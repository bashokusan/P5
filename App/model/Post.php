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
  private $author;
  private $title;
  private $kicker;
  private $content;
  private $publishDate;
  private $updateDate;
  private $countComment;

  // Getters

  public function getId() :int
  {
    return $this->id;
  }

  public function getAuthor() : string
  {
    return htmlentities($this->author);
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
    return date("d/m/Y", strtotime($this->publishDate));
  }

  public function getUpdateDate() : ?string
  {
    if($this->updateDate){
      return date("d/m/Y", strtotime($this->updateDate));
    }else{
      return null;
    }
  }

  public function getCountComment() :?string
  {
    if($this->countComment === null)
    {
      return null;
    }
    return $this->countComment;
  }
}
