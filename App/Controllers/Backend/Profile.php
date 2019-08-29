<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\User;
use App\Models\UserManager;

/**
 *
 */
class Profile extends Controller
{
    //------------------------------------------------------------------------------
    // Profile Page Methods
    //------------------------------------------------------------------------------
    /**
     * Profile page
     */
    public function profilePage()
    {
        $id = $_SESSION['id'];
        $token = $_SESSION['t_user'];

        $db = DBFactory::getPDO();
        $userManager = new UserManager($db);
        $user = $userManager->getUser($id);

        if (isset($_POST['updateprofile']) && isset($_POST['userid'])) {
            $data = [
      'id' => (int)$_POST['userid'],
      'name' => htmlentities($_POST['name']),
      'email' => htmlentities($_POST['email']),
    ];

            $updateuser = new User($data);

            if ($updateuser->isValid()) {
                $userManager->updateinfos($updateuser);
                $message = "Vos informations ont été modifiées.";
            } else {
                $errors = $updateuser->errors();
            }
        }

        ob_start();
        require_once $this->getViewPath().'profile.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }
}