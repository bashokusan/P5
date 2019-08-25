<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\SendEmail;
use App\Models\DBFactory;
use App\Models\Message;
use App\Models\MessageManager;
use App\Models\Post;
use App\Models\PostManager;
use App\Models\Comment;
use App\Models\CommentManager;
use App\Models\User;
use App\Models\UserManager;

/**
 * Main controller, action to do when called by the router
 */
class BackendController extends Controller
{

//------------------------------------------------------------------------------
    // METHODS
    //------------------------------------------------------------------------------

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
                $password = htmlspecialchars($_POST['password']);
                $passwordConfirm = htmlspecialchars($_POST['passwordbis']);

                if ($password === $passwordConfirm) {
                    $db = DBFactory::getPDO();
                    $userManager = new UserManager($db);

                    // For user who reset password
                    if (isset($_POST['selector']) && isset($_POST['validator']) && !empty($_POST['selector']) && !empty($_POST['validator'])) {
                        $currentDateTime = date('U');

                        // Check if there is a pending request with selector in form
                        $resetpass = $userManager->getResetPass($_POST['selector'], $currentDateTime);
                        if (!$resetpass) {
                            $error = "Une erreur est survenue. Veuillez soumettre une nouvelle réinitialisation.";
                        }

                        // Compare token in Databse with token in form
                        $tokenBin = (string)hex2bin($_POST['validator']);
                        $tokenCheck = password_verify($tokenBin, $resetpass['token']);

                        if ($tokenCheck) {
                            $user = $userManager->getUserByMail($resetpass['email']);
                            $id = $user->id();

                            $passhash = password_hash($password, PASSWORD_DEFAULT);
                            $userManager->update($id, (string)$passhash);
                            $userManager->deletePassReset($_POST['selector']);
                            $this->logout();
                            header('Location: ?page=login');
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
                        $this->logout();
                        header('Location: ?page=login');
                    }
                    // If confirmed admin
                    else {
                        $passhash = password_hash($password, PASSWORD_DEFAULT);
                        $userManager->update($id, (string)$passhash);
                        $this->logout();
                        header('Location: ?page=login');
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

    //------------------------------------------------------------------------------
    // Log Out Page Methods
    //------------------------------------------------------------------------------
    /**
     * Destroy session when logout
     */
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: ?page=login');
    }

    /**
     * Check if user connected or not
     * @param  string $role [description]
     * @return bool True if there is a role session var
     */
    public function loggedIn($role = null)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == $role) {
            return true;
        } else {
            return false;
        }
    }


    //------------------------------------------------------------------------------
    // Not logged in User Methods
    //------------------------------------------------------------------------------
    //------------------------------------------------------------------------------
    // Login Page Methods
    //------------------------------------------------------------------------------
    /**
    * Call for login page
    * Check if user infos are valid and create session
    */
    public function login()
    {
        if (isset($_POST['login'])) {
            $data = [
        'email' => htmlentities($_POST['email']),
        'password' => htmlentities($_POST['password'])
      ];
            // Save inputs in session
            $_SESSION['inputs'] = $_POST;

            $db = DBFactory::getPDO();
            $user = new User($data);
            $userManager = new UserManager($db);

            // Use Ip (see connect method for brute force attack defense)
            $ip = $_SERVER['REMOTE_ADDR'];
            $connect = $userManager->connect($ip);

            // User will be ban is there are more than 3 failed connections.
            if ($connect <= 3) {
                if ($connect == 3) {
                    $warning = "Attention, il vous reste un seul essai. <a href='?page=resetpass'>Mot de passe oublié ?</a>";
                }

                if ($user->isValid()) {
                    // get user from database with email from form
                    $loggingUser = $userManager->getUserByMail($user->email());

                    if ($loggingUser) {
                        $passwordCheck = password_verify($user->password(), $loggingUser->password());
                        if ($passwordCheck) {
                            // Restore failed connection to 0
                            if ($connect) {
                                $userManager->restoreConnect($ip, $loggingUser->id());
                            }

                            // If user is confirmed (has changed his password once)
                            if ($loggingUser->confirm() == 1) {
                                session_start();
                                $token = bin2hex(random_bytes(32));
                                $_SESSION['t_user'] = $token;
                                $_SESSION['role'] = 'admin';
                                $_SESSION['id'] = $loggingUser->id();
                                $_SESSION['inputs'] = [];
                                header('Location: ?page=home');
                            }
                            // If user is new and has not changed his password yet
                            elseif ($loggingUser->confirm() == 0) {
                                session_start();
                                $token = bin2hex(random_bytes(32));
                                $_SESSION['t_user'] = $token;
                                $_SESSION['role'] = 'guest';
                                $_SESSION['id'] = $loggingUser->id();
                                $_SESSION['inputs'] = [];
                                header('Location: ?page=newpass');
                            }
                        } else {
                            $prohib = "Informations de connection éronées (mdp)";
                            // Save the failed connection into dabatase
                            $failconnect = $userManager->failConnect($ip, $loggingUser->id());
                        }
                    } else {
                        $prohib = "Informations de connection éronées";
                    }
                } else {
                    $errors = $user->errors();
                }
            } else {
                throw new \Exception("Votre accès est bloqué. Contactez l'administrateur.");
            }
        }

        ob_start();
        require_once $this->getViewPath().'login.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }


    //------------------------------------------------------------------------------
    // Reset Password Page Methods
    //------------------------------------------------------------------------------
    /**
     * Reset Pass
     */
    public function resetPassPage()
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


    //------------------------------------------------------------------------------
    // Contribute Page Methods (Not logged in user)
    //------------------------------------------------------------------------------
    /**
     * Page to request admin role
     * Save email and message from request form into the database
     */
    public function requestPage()
    {
        if ($_POST['request']) {
            $data = [
        'name' => htmlentities($_POST['name']),
        'email' => htmlentities($_POST['email']),
        'message' => htmlentities($_POST['message'])
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
