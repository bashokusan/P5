<?php

namespace App\model;

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
    return "<h2>" . $this->title . "</h2>";
  }

  public function getKicker(){
    return "<h3>" . $this->kicker . "</h3>";
  }

  public function getContent(){
    return "<p>" . nl2br($this->content) . "</p>";
  }

  public function getPublishDate(){
    return "<p><em>Publié le " . $this->publish_date . "</em></p>";
  }

  public function getUpdateDate(){
    if($this->update_date){
      return "<p><em>Modifié le " . $this->update_date . "</em></p>";
    }else{
      return null;
    }
  }

}
