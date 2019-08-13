<?php

/**
 * Class for user object defining a user
 */
class User
{

  private $errors = [];
  private $id;
  private $email;
  private $password;

  const EMAIL_INVALID = 1;
  const PASSWORD_INVALID = 2;

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
    return !(empty($this->email) || empty($this->password));
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
  public function setEmail($email)
  {
    if(!is_string($email) || empty($email))
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


  // Getters

  public function errors()
  {
    return $this->errors;
  }

  public function id()
  {
    return $this->id;
  }

  public function email()
  {
    return $this->email;
  }

  public function password()
  {
    return $this->password;
  }

}
