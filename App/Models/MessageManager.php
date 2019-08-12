<?php

/**
 * []
 */
class MessageManager
{

  public function send(Message $message){

    $from = ['contact@monsite.fr' => 'Contact'];
    $to = ['moi@mail.com' => 'moi'];

    $content = "Nouveau message de : " . $message->name() . " (" . $message->email() . ") : " . $message->message();

    $contentHtml = "
      <p>Nouveau message de".$message->name()."(".$message->email().") : </p>
      <p>".$message->message()."</p>
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

}
