<?php

/**
 * Class for post object defining a post
 */
class Post
{

  private $errors = [];
  private $id;
  private $author;
  private $title;
  private $kicker;
  private $content;
  private $publishDate;
  private $updateDate;
  private $countComment;

  const AUTHOR_INVALID = 1;
  const TITLE_INVALID = 2;
  const KICKER_INVALID = 3;
  const CONTENT_INVALID = 4;

  public function __construct(array $values = [])
  {
    if(!empty($values))
    {
      $this->hydrate($values);
    }
  }

  /**
   * Hydrate the object with data
   * @param  array $data Usually from post form when add or update post
   */
  public function hydrate($data)
  {
    foreach($data as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if(is_callable([$this, $method]))
      {
        $this->$method($value);
      }
    }
  }

  /**
   * Check if object is new
   * @return bool true if new, false if not new
   */
  public function isNew() :bool
  {
    return empty($this->id);
  }

  /**
   * Check if object is valid
   * @return bool true if every item is not empty, false if at least one item is empty
   */
  public function isValid() :bool
  {
    return !(empty($this->author) || empty($this->title) || empty($this->kicker) || empty($this->content));
  }

  // Setters

  public function setId($id)
  {
    $this->id = (int)$id;
  }

  /**
   * Set author, is not a string or empty, new error.
   * @param string $author Author of the post
   */
  public function setAuthor($author)
  {
    if(!is_string($author) || empty($author))
    {
      $this->errors[] = self::AUTHOR_INVALID;
    }
    else
    {
      $this->author = $author;
    }
  }

  /**
   * Set title, is not a string or empty, new error.
   * @param string $title Title of the post
   */
  public function setTitle($title)
  {
    if(!is_string($title) || empty($title))
    {
      $this->errors[] = self::TITLE_INVALID;
    }
    else
    {
      $this->title = $title;
    }
  }

  /**
   * Set Kicker, is not a string or empty, new error.
   * @param string $kicker Kicker of the post
   */
  public function setKicker($kicker)
  {
    if(!is_string($kicker) || empty($kicker))
    {
      $this->errors[] = self::KICKER_INVALID;
    }
    else
    {
      $this->kicker = $kicker;
    }
  }

  /**
   * Set content, is not a string or empty, new error.
   * @param string $content Content of the post
   */
  public function setContent($content)
  {
    if(!is_string($content) || empty($content))
    {
      $this->errors[] = self::CONTENT_INVALID;
    }
    else
    {
      $this->content = $content;
    }
  }

  public function setPublishDate($publishDate)
  {
    $this->publishDate = $publishDate;
  }

  public function setUpdatDate($updateDate)
  {
    $this->updateDate = $updateDate;
  }

  public function setCountComment($countComment)
  {
    $this->countComment = $countComment;
  }


  // Getters

  public function errors()
  {
    return $this->errors;
  }

  public function id()
  {
    return $this->id;
  }

  public function title()
  {
    return $this->title;
  }

  public function author() :?string
  {
    return $this->author;
  }

  public function kicker()
  {
    return $this->kicker;
  }

  public function content()
  {
    return $this->content;
  }

  public function publishDate()
  {
    return $this->publishDate;
  }

  public function updateDate() :?string
  {
    return $this->updateDate;
  }

  public function countComment()
  {
    if($this->countComment == 0){
      return null;
    }
    return $this->countComment;
  }

}
