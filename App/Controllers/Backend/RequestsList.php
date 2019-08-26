<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\UserManager;
use App\Controllers\Helpers\SendEmail;

/**
 *
 */
class RequestsList extends Controller
{
    //------------------------------------------------------------------------------
    // Requests Page Methods (Admin)
    //------------------------------------------------------------------------------
    /**
     * Requests page
     * Displays standing by requests and accepted request
     */
    public function adminRequestPage()
    {
        $db = DBFactory::getPDO();
        $userManager = new UserManager($db);

        $userList = $userManager->getList('new');
        $acceptedUserList = $userManager->getList('accepted');

        ob_start();
        require_once $this->getViewPath().'adminrequest.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }

    /**
     * Call when accept link clicked on requests page
     * @param int $id User id
     */
    public function acceptRequest($id)
    {
        $pass = rand(10000000, 99999999);
        $hashPass = password_hash((string)$pass, PASSWORD_DEFAULT);

        $db = DBFactory::getPDO();
        $userManager = new UserManager($db);
        $user = $userManager->getUser($id);

        if ($hashPass) {
            $userManager->acceptRequest($id, $hashPass);
        }

        $mailContentText = "Bonjour ".$user->name().", voici votre mot de passe temporaire : ".$pass." Le lien d'accès : http://localhost/P5/Backoffice/index.php A bientôt.";

        $mailContentHtml = "<p>Bonjour ".$user->name()."</p><p>Votre mot de passe temporaire : ".$pass."</p><p><a href='http://localhost/P5/Backoffice/index.php'>Lien d'accès</a></p>";

        $mailTopic = "Bienvenue parmi nous";

        $send = new SendEmail();
        $send->sendMail($user->email(), $mailContentText, $mailContentHtml, $mailTopic);
    }
}
