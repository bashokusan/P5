<?php

/**
 * Class for comment object defining a comment
 * Created when comment form is submitted
 */
class Comment
{

  private $errors = [];
  private $id;
  private $idArticle;
  private $author;
  private $content;
  private $publishDate;

  const AUTHOR_INVALID = 1;
  const CONTENT_INVALID = 2;
  const CONTENT_LENGHT = 3;

  public function __construct(array $values = [])
  {
    if(!empty($values))
    {
      $this->hydrate($values);
    }
  }

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
    return !(empty($this->idArticle) || empty($this->author) || empty($this->content));
  }

  // Setters

  public function setId($id)
  {
    $this->id = (int)$id;
  }

  public function setIdArticle($idArticle)
  {
    $this->idArticle = (int)$idArticle;
  }

  /**
   * Set author, is not a string or empty, new error.
   * @param string $author Author of the comment from comment form post
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
   * Set content, is not a string or empty, new error.
   * @param string $content Content of the comment from comment form post
   */
  public function setContent($content)
  {
    if(!is_string($content) || empty($content))
    {
      $this->errors[] = self::CONTENT_INVALID;
    }
    elseif (!empty($content) && (strlen($content) < 2 || strlen($content) > 500 )) {
      $this->errors[] = self::CONTENT_LENGHT;
    }
    else
    {
      $this->content = nl2br($content);
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


  // Getters

  public function errors()
  {
    return $this->errors;
  }

  public function id()
  {
    return $this->id;
  }

  public function idArticle()
  {
    return $this->idArticle;
  }

  public function author()
  {
    return $this->author;
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

}
