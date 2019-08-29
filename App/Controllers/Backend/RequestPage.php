<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\User;
use App\Models\UserManager;

/**
 *
 */
class RequestPage extends Controller
{
  //------------------------------------------------------------------------------
  // Contribute Page Methods (Not logged in user)
  //------------------------------------------------------------------------------
  /**
   * Page to request admin role
   * Save email and message from request form into the database
   */
  public function requestPage()
  {
      if (isset($_POST['request'])) {
          $data = [
      'name' => htmlentities((string)$_POST['name']),
      'email' => htmlentities((string)$_POST['email']),
      'message' => htmlentities((string)$_POST['message'])
    ];

          $_SESSION['inputs'] = $_POST;

          $user = new User($data);
          $db = DBFactory::getPDO();
          $userManager = new UserManager($db);

          if ($user->isValid()) {
              $userManager->add($user);
              $message = "Votre demande a bien été envoyé, vous recevrez un mail si elle est acceptée";
              $_SESSION['inputs'] = [];
          } else {
              $errors = $user->errors();
          }
      }

      ob_start();
      require_once $this->getViewPath().'request.php';
      $content = ob_get_clean();
      require_once $this->getTemplatePath();
  }
}
