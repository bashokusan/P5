<?php

namespace App\Model;

use App\model\ContactManager;

class Contact
{
  private $name;
  private $email;
  private $message;

  public function __construct($name, $email, $message)
  {
    $this->setName($name);
    $this->setEmail($email);
    $this->setMessage($message);
  }

  // setters
  private function setName($name)
  {
    $this->name = $name;
  }

  private function setEmail($email)
  {
    $this->email = $email;
  }

  private function setMessage($message)
  {
    $this->message = $message;
  }

  // getters
  private function getName()
  {
    return $this->name;
  }

  private function getEmail()
  {
    return $this->email;
  }

  private function getMessage()
  {
    return $this->message;
  }

  /**
   * Envoi du message
   * @return bool retournera true si le message est bien envoyé
   */
  public function sendMessage() :bool
  {
    $send = ContactManager::sendMessage($this->getName(), $this->getEmail(), $this->getMessage());
    $send .= ContactManager::sendCopy($this->getName(), $this->getEmail(), $this->getMessage());
    return $send;
  }

}
