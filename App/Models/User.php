<?php

/**
 * Class for user object defining a user
 */
class User
{

  private $errors = [];
  private $id;
  private $name;
  private $email;
  private $password;
  private $message;
  private $requestDate;
  private $accept;
  private $confirm;

  const NAME_INVALID = 1;
  const EMAIL_INVALID = 2;
  const PASSWORD_INVALID = 3;
  const MESSAGE_INVALID = 4;

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
   * Check if object is valid
   * @return bool true if every item is not empty, false if at least one item is empty
   */
  public function isValid() :bool
  {
    return (empty($this->errors));
  }

  // Setters

  public function setId($id)
  {
    $this->id = (int)$id;
  }

  /**
   * Set email, is not a string or empty, new error.
   * @param string $email Email of the user
   */
  public function setname($name)
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

  /**
   * Set email, is not a string or empty, new error.
   * @param string $email Email of the user
   */
  public function setEmail($email)
  {
    if(!is_string($email) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $this->errors[] = self::EMAIL_INVALID;
    }
    else
    {
      $this->email = $email;
    }
  }

  /**
   * Set password, is not a string or empty, new error.
   * @param string $password Password of the user
   */
  public function setPassword($password)
  {
    if(!is_string($password) || empty($password))
    {
      $this->errors[] = self::PASSWORD_INVALID;
    }
    else
    {
      $this->password = $password;
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

  public function setRequestDate($requestDate)
  {
    $this->requestDate = $requestDate;
  }

  public function setAccept($accept)
  {
    $this->accept = (int)$accept;
  }

  public function setConfirm($confirm)
  {
    $this->confirm = (int)$confirm;
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

  public function name()
  {
    return $this->name;
  }

  public function email()
  {
    return $this->email;
  }

  public function password()
  {
    return $this->password;
  }

  public function message()
  {
    return $this->message;
  }

  public function requestDate()
  {
    return $this->requestDate;
  }

  public function accept()
  {
    return $this->accept;
  }

  public function confirm()
  {
    return $this->confirm;
  }

}
