<?php

/**
 *
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

  //
  public function isNew() :bool
  {
    return empty($this->id);
  }

  //
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
