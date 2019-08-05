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
    if($this->update_date){
      return "Modifié le " . $this->update_date;
    }else{
      return null;
    }
  }

}
