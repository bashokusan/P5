<?php

/**
 * Main controller, action to do when called by the router
 */
class BackendController extends Controller
{

//------------------------------------------------------------------------------
// METHODS
//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
// Hack Defense Methods
//------------------------------------------------------------------------------
  /**
   * Session hijacking defense function
   */
  public function sessionHijack()
  {
    $token = bin2hex(random_bytes(32));
    setcookie('u_log', $token, time() + (60 * 20));
    $_SESSION['u_log'] = $token;
  }


  /**
   * CSRF defense function
   * If token in url different from token in session, logout user
   */
  public function csrf()
  {
    if(isset($_GET['token']) && !empty($_GET['token']))
    {
      // If token in url is different from token in session and cookie, session is destroyed
      if($_GET['token'] != $_SESSION['t_user'])
      {
        $_SESSION = [];
        session_destroy();
        header('location:index.php');
      }
    }

    if (isset($_POST['t_user']) && !empty($_POST['t_user']))
    {
      if ($_POST['t_user'] != $_SESSION['t_user'])
      {
        $_SESSION = [];
        session_destroy();
        header('location:index.php');
      }
    }
  }


//------------------------------------------------------------------------------
// Home Page Methods
//------------------------------------------------------------------------------
  /**
   * Home page
   * Main dashboard with number of posts, comments and unchecked comments list
   */
  public function homepage()
  {
    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);
    $commentManager = new CommentManager($db);

    $data =
    [
      'token' => $_SESSION['t_user'],
      'postsCount' => $postManager->count(),
      'commentCount' => $commentManager->count(),
      'uncheckedCount' => $commentManager->count('unchecked'),
      'uncheckedComment' => $commentManager->getListNoId('unchecked')
    ];

    $this->render('home', $data);
  }


  /**
   * Update comment for checked
   * @param  int $idcomment [description]
   * @param  int $idpost    [description]
   */
  public function updateComment($idcomment, $idpost)
  {
    $db = DBFactory::getPDO();
    $commentManager = new CommentManager($db);
    $commentManager->updateCheck($idcomment, $idpost, 1);

    header('Location: ?page=home');
  }


  /**
   * Update comment for flag
   * @param  int $idcomment [description]
   * @param  int $idpost    [description]
   */
  public function flagComment($idcomment, $idpost)
  {
    $db = DBFactory::getPDO();
    $commentManager = new CommentManager($db);
    $commentManager->updateCheck($idcomment, $idpost, 2);

    header('Location: ?page=home');
  }


//------------------------------------------------------------------------------
// Posts Page Methods
//------------------------------------------------------------------------------
  /**
   * Posts page
   * Displays all posts
   */
  public function postsPage()
  {
    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);

    $data =
    [
      'token' => $_SESSION['t_user'],
      'postList' => $postManager->getList()
    ];

    $this->render('posts', $data);
  }


  /**
   * Deletion of post and its comments
   * @param  int $id Post id
   */
  public function deletePost($id)
  {
    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);
    $postManager->delete($id);

    header('Location: ?page=posts');
  }


//------------------------------------------------------------------------------
// Edit Page Methods
//------------------------------------------------------------------------------
  /**
   * Edit page
   * Update or create new post
   */
  public function editPage()
  {
    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);
    $userManager = new UserManager($db);
    $users = $userManager->getList('confirmed');
    $loggedinUser = $userManager->getUser((int)$_SESSION['id']);

    $token = $_SESSION['t_user'];
    $_SESSION['inputs'] = [];

    if(isset($_GET['postid']) && !empty($_GET['postid']))
    {
      $id = (int)$_GET['postid'];
      $post = $postManager->getUnique($id);
    }

    if(isset($_POST['idauthor']))
    {
      $_SESSION['inputs'] = $_POST;

      if (isset($_FILES['image']) && !empty($_FILES['image']['name']))
      {
        if($_FILES['image']['error'] === 0)
        {
          $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
          $infosfichier = pathinfo($_FILES['image']['name']);
          $extension_upload = strtolower($infosfichier['extension']);
          if (in_array($extension_upload, $extensions_autorisees))
          {
            if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= 2000000)
            {
              $fileName = uniqid(). "." .$infosfichier['extension'];
            }
            else
            {
              $imgerrors = "Le fichier doit faire moins de 2mo";
            }
          }
          else
          {
            $imgerrors = "Le fichier n'est pas au bon format";
          }
        }
        else
        {
          $imgerrors = "Le fichier est invalide";
        }
      }
      elseif(isset($_POST['currentimg']) && !empty($_POST['currentimg']))
      {
        $fileName = htmlentities($_POST['currentimg']);
      }

      $data = [
        'idauthor' => (int)$_POST['idauthor'],
        'image' => $fileName,
        'title' => htmlentities($_POST['title']),
        'kicker' => htmlentities($_POST['kicker']),
        'content' => htmlentities($_POST['content'])
      ];

      $newPost = new Post($data);

      if(isset($_GET['postid']) && !empty($_GET['postid']))
      {
        $newPost->setId($_POST['id']);
      }

      if($newPost->isValid() && empty($imgerrors))
      {
        $postManager->save($newPost);

        if($newPost->id()){
          $id = $newPost->id();
        }else{
          $id = $db->lastInsertId();
        }

        if($fileName)
        {
          $path = '../Public/Content/post-'.$id;
          if(!file_exists($path)){
            mkdir($path,0777, true);
          }
          move_uploaded_file($_FILES['image']['tmp_name'], $path . DIRECTORY_SEPARATOR . $fileName);

          $postManager->uploadImg($fileName, (int)$id);
        }

        header('Location: ?page=posts');

      }
      else
      {
        $errors = $newPost->errors();
      }
    }

    ob_start();
    require_once $this->getViewPath().'edit.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }


//------------------------------------------------------------------------------
// Comments Page Methods
//------------------------------------------------------------------------------
  /**
   * Comments page
   * Displays all comments ordered by posts
   */
  public function commentsPage()
  {
    $db = DBFactory::getPDO();
    $commentManager = new CommentManager($db);

    $data =
    [
      'flagComments' => $commentManager->getListNoId('flag'),
      'flagCommentsCount' => $commentManager->count('flag'),
      'checkedComment' => $commentManager->getListNoId('checked'),
      'checkedCommentsCount' => $commentManager->count('checked'),
      'commentsList' => $commentManager->getListNoId(),
      'CommentsCount' => $commentManager->count()
    ];

    $this->render('comments', $data);
  }



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

    $data =
    [
      'userList' => $userManager->getList('new'),
      'acceptedUserList' => $userManager->getList('accepted'),
    ];

    $this->render('adminrequest', $data);
  }

  /**
   * Call when accept link clicked on requests page
   */
  public function acceptRequest($id)
  {
    $pass = rand(10000000, 99999999);
    $hashPass = password_hash($pass, PASSWORD_DEFAULT);

    $db = DBFactory::getPDO();
    $userManager = new UserManager($db);
    $user = $userManager->getUser($id);

    $userManager->acceptRequest($id, $hashPass);

    $mailContentText = "Bonjour ".$user->name().", voici votre mot de passe temporaire : ".$pass." Le lien d'accès : http://localhost/P5/Backoffice/index.php A bientôt.";

    $mailContentHtml = "<p>Bonjour ".$user->name()."</p><p>Votre mot de passe temporaire : ".$pass."</p><p><a href='http://localhost/P5/Backoffice/index.php'>Lien d'accès</a></p>";

    $mailTopic = "Bienvenue parmis nous";

    $this->sendMail($user->email(), $mailContentText, $mailContentHtml, $mailTopic);
  }


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

    if(isset($_POST['updateprofile']))
    {
      $data = [
        'id' => (int)$_POST['userid'],
        'name' => htmlentities($_POST['name']),
        'email' => htmlentities($_POST['email']),
      ];

      $updateuser = new User($data);

      if($updateuser->isValid())
      {
        $userManager->updateinfos($updateuser);
        $message = "Vos informations ont été modifiées.";
      }
      else
      {
        $errors = $updateuser->errors();
      }
    }

    ob_start();
    require_once $this->getViewPath().'profile.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }


//------------------------------------------------------------------------------
// Change or Reset Password Page Methods
//------------------------------------------------------------------------------
  /**
   * Page to create new password
   * Also used when reset password
   */
  public function newPassPage()
  {
    if($_POST['updatemdp'])
    {
      if (!empty($_POST['password'] && !empty($_POST['passwordbis'])))
      {
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordbis'];

        if($password === $passwordConfirm)
        {
          $db = DBFactory::getPDO();
          $userManager = new UserManager($db);

          // For user who reset password
          if(isset($_POST['selector']) && isset($_POST['validator'] ) && !empty($_POST['selector']) && !empty($_POST['validator']))
          {
            $currentDateTime = date('U');

            // Check if there is a pending request with selector in form
            $resetpass = $userManager->getResetPass($_POST['selector'], $currentDateTime);
            if (!$resetpass)
            {
              $error = "Une erreur est survenue. Veuillez soumettre une nouvelle réinitialisation.";
            }

            // Compare token in Databse with token in form
            $tokenBin = hex2bin($_POST['validator']);
            $tokenCheck = password_verify($tokenBin, $resetpass['token']);

            if($tokenCheck){
              $user = $userManager->getUserByMail($resetpass['email']);
              $id = $user->id();

              $passhash = password_hash($password, PASSWORD_DEFAULT);
              $userManager->update($id, $passhash);
              $userManager->deletePassReset($_POST['selector']);
              $this->logout();
              header('Location: ?page=login');

            }else {
              $error = "Une erreur est survenue. Veuillez soumettre une nouvelle réinitialisation.";
            }
          }
          // For users who change password
          $user = $userManager->getUser($_SESSION['id']);
          $id = $user->id();
          // If not confirmed (ie first login and has not changed pass yet)
          if($user->confirm() == 0)
          {
            $passhash = password_hash($password, PASSWORD_DEFAULT);
            $userManager->update($id, $passhash, 'confirm');
            $this->logout();
            header('Location: ?page=login');
          }
          // If confirmed admin
          else
          {
            $passhash = password_hash($password, PASSWORD_DEFAULT);
            $userManager->update($id, $passhash);
            $this->logout();
            header('Location: ?page=login');
          }
        }
        else
        {
          $error = "les mots de passe ne correspondent pas.";
        }
      }
      else
      {
        $error = "Veuillez remplir les champs";
      }
    }

    ob_start();
    require_once $this->getViewPath().'newpass.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
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
  }

  /**
   * Check if user connected or not
   * @return bool True if there is a role session var
   */
  public function loggedIn($role = null)
  {
    if(isset($_SESSION['role']) && $_SESSION['role'] == $role)
    {
      return true;
    }else {
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
    if(isset($_POST['login']))
    {
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
      if($connect <= 3)
      {
        if($connect == 3){
          $warning = "Attention, il vous reste un seul essai. <a href='?page=resetpass'>Mot de passe oublié ?</a>";
        }

        if($user->isValid())
        {
          // get user from database with email from form
          $loggingUser = $userManager->getUserByMail($user->email());

          if($loggingUser)
          {
            $passwordCheck = password_verify($user->password(), $loggingUser->password());
            if($passwordCheck)
            {
              // Restore failed connection to 0
              if($connect){
                $userManager->restoreConnect($ip, $loggingUser->id());
              }

              // If user is confirmed (has changed his password once)
              if($loggingUser->confirm() == 1)
              {
                session_start();
                $token = bin2hex(random_bytes(32));
                $_SESSION['t_user'] = $token;
                $_SESSION['role'] = 'admin';
                $_SESSION['id'] = $loggingUser->id();
                $_SESSION['inputs'] = [];
                header('Location: ?page=home');
              }
              // If user is new and has not changed his password yet
              elseif($loggingUser->confirm() == 0)
              {
                session_start();
                $token = bin2hex(random_bytes(32));
                $_SESSION['t_user'] = $token;
                $_SESSION['role'] = 'guest';
                $_SESSION['id'] = $loggingUser->id();
                $_SESSION['inputs'] = [];
                header('Location: ?page=newpass');
              }
            }
            else
            {
              $prohib = "Informations de connection éronées (mdp)";
              // Save the failed connection into dabatase
              $failconnect = $userManager->failConnect($ip, $loggingUser->id());
            }
          }
          else
          {
            $prohib = "Informations de connection éronées";
          }
        }
        else
        {
          $errors = $user->errors();
        }
      }
      else
      {
        throw new \Exception("Votre accès est bloqué. Contactez l'administrateur.");
      }
    }

    ob_start();
    require_once $this->getViewPath().'login.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }


//------------------------------------------------------------------------------
// Reset Password Page Methods
//------------------------------------------------------------------------------
  /**
   * Reset Pass
   */
  public function resetPassPage()
  {
    if(isset($_POST['resetpass']))
    {
      if(!empty($_POST['email']))
      {
        $email = htmlentities($_POST['email']);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          $db = DBFactory::getPDO();
          $userManager = new UserManager($db);

          // get user from database with email from form
          $loggingUser = $userManager->getUserByMail($email);

          if($loggingUser)
          {
            $selector = bin2hex(random_bytes(8));
            // not encrypted token to be inserted in the databse
            $token = random_bytes(32);
            // encrypted token inserted in the url
            $cryptoken = bin2hex($token);

            $expire = date('U') + 3600;

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

            $this->sendMail($loggingUser->email(), $mailContentText, $mailContentHtml, $mailTopic);

            $info = "Un email contenant un lien de réinitialisation vous a été envoyé";
          }
          else{
            $warning = "Erreur. Veuillez réessayer";
          }
        }
        else
        {
          $warning = "L'email est invalide";
        }
      }
      else
      {
        $warning = "Le champ doit être rempli";
      }
    }

    ob_start();
    require_once $this->getViewPath().'resetpass.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
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
    if($_POST['request'])
    {
      $data = [
        'name' => htmlentities($_POST['name']),
        'email' => htmlentities($_POST['email']),
        'message' => htmlentities($_POST['message'])
      ];

      $_SESSION['inputs'] = $_POST;

      $user = new User($data);
      $db = DBFactory::getPDO();
      $userManager = new UserManager($db);

      if($user->isValid())
      {
        $userManager->add($user);
        $message = "Votre demande a bien été envoyé, vous recevrez un mail si elle est acceptée";
        $_SESSION['inputs'] = [];
      }
      else
      {
        $errors = $user->errors();
      }
    }

    ob_start();
    require_once $this->getViewPath().'request.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }


//------------------------------------------------------------------------------
// Send Mail Methods
//------------------------------------------------------------------------------
  /**
   * Send email to user (see above)
   * @return bool
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
