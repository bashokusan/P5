<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;
use App\Controllers\SendEmail;
use App\Models\DBFactory;
use App\Models\User;
use App\Models\UserManager;


/**
 *
 */
class ResetPass extends Controller
{
  //------------------------------------------------------------------------------
  // Reset Password Page Methods
  //------------------------------------------------------------------------------
  /**
   * Reset Pass
   */
  public function resetPass()
  {
      if (isset($_POST['resetpass'])) {
          if (!empty($_POST['email'])) {
              $email = htmlentities($_POST['email']);

              if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $db = DBFactory::getPDO();
                  $userManager = new UserManager($db);

                  // get user from database with email from form
                  $loggingUser = $userManager->getUserByMail($email);

                  if ($loggingUser) {
                      $selector = bin2hex(random_bytes(8));
                      // not encrypted token to be inserted in the databse
                      $token = random_bytes(32);
                      // encrypted token inserted in the url
                      $cryptoken = bin2hex($token);

                      $expire = (int)date('U') + 3600;

                      // Create a new line for this user in resetpass table
                      $userManager->resetPass($loggingUser->email(), $selector, $token, $expire);

                      $mailContentText = "Bonjour ".$loggingUser->name().". Une demande de réinitialisation de votre mot de passe a été faite. Réinitialisez votre mot en passe en cliquant sur le lien suivant : http://localhost/P5/Backoffice/index.php?page=reset&restoken=$selector&validator=$cryptoken Attention, le lien est actif pendant une heure. Si la demande ne vient pas de vous, ignorez ce message.";

                      $mailContentHtml =
          "<p>Bonjour ".$loggingUser->name()."</p>
          <p>Une demande de réinitialisation de votre mot de passe a été faite.</p>
          <p>Réinitialisez votre mot en passe en cliquant sur le lien suivant : <a href='http://localhost/P5/Backoffice/index.php?page=reset&restoken=$selector&validator=$cryptoken'>Réinitialiser</a></p>
          <p>Attention, le lien est actif pendant une heure.</p>
          <p>Si la demande ne vient pas de vous, ignorez ce message</p>";

                      $mailTopic = "Réinitialisation de votre mot de passe";

                      $send = new SendEmail();
                      $send->sendMail($loggingUser->email(), $mailContentText, $mailContentHtml, $mailTopic);

                      $info = "Un email contenant un lien de réinitialisation vous a été envoyé";
                  } else {
                      $warning = "Erreur. Veuillez réessayer";
                  }
              } else {
                  $warning = "L'email est invalide";
              }
          } else {
              $warning = "Le champ doit être rempli";
          }
      }

      ob_start();
      require_once $this->getViewPath().'resetpass.php';
      $content = ob_get_clean();
      require_once $this->getTemplatePath();
  }
}
