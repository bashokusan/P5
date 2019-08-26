<?php

namespace App\Controllers\Helpers;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

/**
 *
 */
class SendEmail
{

  /**
   * Send email to user (see above)
   * @param string $userMail
   * @param string $contentText
   * @param string $contentHtml
   * @param string $topic
   * @return int
   */
    public function sendMail($userMail, $contentText, $contentHtml, $topic)
    {
        $from = ['contact@monsite.fr' => 'Contact'];
        $to = $userMail;

        $content = $contentText;

        $contentHtml = $contentHtml;

        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
          ->setUsername('d481f137380620')
          ->setPassword('8282c28192de76')
      ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($topic))
        ->setFrom($from)
        ->setTo($to)
        ->setBody($content, 'text/plain')
        ->addPart($contentHtml, 'text/html');

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }
}
