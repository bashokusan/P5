<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Controllers\Backend\Logout;
use App\Models\DBFactory;
use App\Models\User;
use App\Models\UserManager;

/**
 *
 */
class NewPass extends Controller
{

  //------------------------------------------------------------------------------
  // Change or Reset Password Page Methods
  //------------------------------------------------------------------------------
  /**
   * Page to create new password
   * Also used when reset password
   */
  public function newPassPage()
  {
      if (isset($_POST['updatemdp'])) {
          if (!empty($_POST['password'] && !empty($_POST['passwordbis']))) {
              $password = htmlspecialchars((string)$_POST['password']);
              $passwordConfirm = htmlspecialchars((string)$_POST['passwordbis']);

              if ($password === $passwordConfirm) {
                  $db = DBFactory::getPDO();
                  $userManager = new UserManager($db);

                  // For user who reset password
                  if (isset($_POST['selector']) && isset($_POST['validator']) && !empty($_POST['selector']) && !empty($_POST['validator'])) {
                      $currentDateTime = date('U');

                      // Check if there is a pending request with selector in form
                      $resetpass = $userManager->getResetPass((string)$_POST['selector'], $currentDateTime);
                      if (!$resetpass) {
                          $error = "Une erreur est survenue. Veuillez soumettre une nouvelle réinitialisation.";
                      }

                      // Compare token in Databse with token in form
                      $tokenBin = hex2bin((string)$_POST['validator']);
                      $tokenCheck = password_verify($tokenBin, $resetpass['token']);

                      if ($tokenCheck) {
                          $user = $userManager->getUserByMail($resetpass['email']);
                          $id = $user->id();

                          $passhash = password_hash($password, PASSWORD_DEFAULT);
                          $userManager->update($id, (string)$passhash);
                          $userManager->deletePassReset((string)$_POST['selector']);
                          $logout = new Logout();
                          $logout->logout();
                      } else {
                          $error = "Une erreur est survenue. Veuillez soumettre une nouvelle réinitialisation.";
                      }
                  }
                  // For users who change password
                  $user = $userManager->getUser($_SESSION['id']);
                  $id = $user->id();
                  // If not confirmed (ie first login and has not changed pass yet)
                  if ($user->confirm() == 0) {
                      $passhash = password_hash($password, PASSWORD_DEFAULT);
                      $userManager->update($id, (string)$passhash, 'confirm');
                      $logout = new Logout();
                      $logout->logout();
                  }
                  // If confirmed admin
                  else {
                      $passhash = password_hash($password, PASSWORD_DEFAULT);
                      $userManager->update($id, (string)$passhash);
                      $logout = new Logout();
                      $logout->logout();
                  }
              } else {
                  $error = "les mots de passe ne correspondent pas.";
              }
          } else {
              $error = "Veuillez remplir les champs";
          }
      }

      ob_start();
      require_once $this->getViewPath().'newpass.php';
      $content = ob_get_clean();
      require_once $this->getTemplatePath();
  }

}
