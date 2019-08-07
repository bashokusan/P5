<?php

namespace App\model;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

/**
 * Envoie du formulaire de contact par email
 */
class ContactManager
{
  public static function sendMessage(string $name, string $email, string $message) :bool
  {
    $from = ['contact@monsite.fr' => 'Contact'];
    $to = ['moi@mail.com' => 'moi'];

    $content = "Nouveau message de : " . $name . " (" . $email . ") : " . $message;

    $contentHtml = "
      <p>Nouveau message de $name ($email) : </p>
      <p>".nl2br($message)."</p>
    ";

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
        ->setUsername('d481f137380620')
        ->setPassword('8282c28192de76')
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Nouveau message'))
      ->setFrom($from)
      ->setTo($to)
      ->setBody($content, 'text/plain')
      ->addPart($contentHtml, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    return $result;
  }

  public static function sendCopy(string $name, string $email, string $message) :bool
  {
    $from = ['contact@monsite.fr' => 'Contact'];
    $to = [$email => $name];

    $content = "Bonjour " . $name . ". Vous avez envoyé le message suivant : '" . $message . "'. Je vous répondrais dès que possible. Bien à vous.";

    $contentHtml = "
      <p>Bonjour $name,</p>
      <p>Je vous remercie pour votre message. Je vous répondrai dès que possible</p>
      <p>Pour rappel, voici votre message :</p>
      <p>".nl2br($message)."</p>
      <p>Bien à vous,</p>
      <p>Pierre</p>
    ";

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
        ->setUsername('d481f137380620')
        ->setPassword('8282c28192de76')
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Votre message'))
      ->setFrom($from)
      ->setTo($to)
      ->setBody($content, 'text/plain')
      ->addPart($contentHtml, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    return $result;
  }
}
