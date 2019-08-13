<?php

/**
 * Manage user
 */
class UserManager
{

  private $db;

  public function __construct(PDO $db)
  {
    $this->setDb($db);
  }

  public function setDb(PDO $db){
    $this->db = $db;
  }


}
