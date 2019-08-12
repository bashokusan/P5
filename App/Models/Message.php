<?php

/**
 *
 */
class Message
{

  private $errors = [];
  private $name;
  private $email;
  private $message;


  const NAME_INVALID = 1;
  const EMAIL_INVALID = 2;
  const MESSAGE_INVALID = 3;

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
  public function isValid() :bool
  {
    return !(empty($this->name) || empty($this->email) || empty($this->message));
  }

  // Setters

  public function setName($name)
  {
    if(!is_string($name) || empty($name))
    {
      $this->errors[] = self::NAME_INVALID;
    }
    else
    {
      $this->name = $name;
    }
  }

  public function setEmail($email)
  {
    if(!is_string($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email))
    {
      $this->errors[] = self::EMAIL_INVALID;
    }
    else
    {
      $this->email = $email;
    }
  }

  public function setMessage($message)
  {
    if(!is_string($message) || empty($message))
    {
      $this->errors[] = self::MESSAGE_INVALID;
    }
    else
    {
      $this->message = $message;
    }
  }


  // Getters

  public function errors()
  {
    return $this->errors;
  }

  public function name()
  {
    return $this->name;
  }

  public function email()
  {
    return $this->email;
  }

  public function message()
  {
    return $this->message;
  }

}
