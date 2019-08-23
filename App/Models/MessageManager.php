<?php

namespace App\Models;

use App\Models\Message;
use App\Controllers\SendEmail;

/**
 * Send message
 */
class MessageManager
{
    /**
     * @param  Message $message Message object created from form post
     * @return bool            1 if message sent, 0 is not
     */
    public function send(Message $message)
    {
        $userMail = 'moi@mail.com';

        $contentText = "Nouveau message de : " . $message->name() . " (" . $message->email() . ") : " . $message->message();

        $contentHtml = "
      <p>Nouveau message de " . $message->name() . " (".$message->email().") : </p>
      <p>".$message->message()."</p>
    ";

        $topic = 'Nouveau message';

        $send = new SendEmail();
        if ($send->sendMail($userMail, $contentText, $contentHtml, $topic)) {
            return true;
        } else {
            return false;
        }
    }
}
