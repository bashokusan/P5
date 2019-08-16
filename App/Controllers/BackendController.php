<?php

/**
 * Main controller, action to do when called by the router
 */
class BackendController
{

  private $viewPath;
  private $templatePath;


  /**
   * Set the viewPath and templatePath
   * @param string $viewPath     Path to pages
   * @param string $templatePath Path to template
   */
  public function __construct($viewPath, $templatePath){
    $this->setViewPath($viewPath);
    $this->setTemplatePath($templatePath);
  }


  // Setters
  public function setViewPath($viewPath){
    $this->viewPath = $viewPath;
  }

  public function setTemplatePath($templatePath){
    $this->templatePath = $templatePath;
  }

  // Getters
  public function getViewPath(){
    return $this->viewPath;
  }

  public function getTemplatePath(){
    return $this->templatePath;
  }


  /**
   * Home page
   * Main dashboard with number of posts, comments and unchecked comments list
   */
  public function homepage(){
    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);
    $commentManager = new CommentManager($db);

    $postsCount = $postManager->count();
    $commentCount = $commentManager->count();

    $uncheckedCount = $commentManager->count('unchecked');
    $uncheckedComment = $commentManager->getListNoId('unchecked');

    ob_start();
    require_once $this->getViewPath().'home.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }


  /**
   * Posts page
   * Displays all posts
   */
  public function postspage(){
    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);
    $postList = $postManager->getList();

    ob_start();
    require_once $this->getViewPath().'posts.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }


  /**
   * Edit page
   * Update or create new post
   */
  public function editpage(){
    ob_start();
    require_once $this->getViewPath().'edit.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }


  /**
   * Comments page
   * Displays all comments ordered by posts
   */
  public function commentspage(){
    $db = DBFactory::getPDO();
    $commentManager = new CommentManager($db);
    $flagComments = $commentManager->getListNoId('flag');
    $flagCommentsCount = $commentManager->count('flag');

    $checkedComment = $commentManager->getListNoId('checked');
    $checkedCommentsCount = $commentManager->count('checked');

    $commentsList = $commentManager->getListNoId();
    $CommentsCount = $commentManager->count();

    ob_start();
    require_once $this->getViewPath().'comments.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }


  /**
   * Page to request admin role
   * Save email and message from request form into the database
   */
  public function requestpage(){

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

  /**
   * Requests page
   * Displays standing by requests and accepted request
   */
  public function adminrequestpage(){

    $db = DBFactory::getPDO();
    $userManager = new UserManager($db);
    $userList = $userManager->getList('new');
    $acceptedUserList = $userManager->getList('accepted');

    ob_start();
    require_once $this->getViewPath().'adminrequest.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }

  /**
   * Call when accept link clicked on requests page
   */
  public function acceptRequest($id){
    $pass = rand(10000, 99999);
    $hashPass = password_hash($pass, PASSWORD_DEFAULT);

    $db = DBFactory::getPDO();
    $userManager = new UserManager($db);
    $user = $userManager->getUser($id);

    $userManager->acceptRequest($id, $hashPass);

    $this->sendAnswer($user->name(), $user->email(), $pass);
  }

  /**
   * Send email to new user (see above)
   * @param  string $userName
   * @param  string $userMail
   * @param  string $pass
   * @return bool
   */
  public function sendAnswer($userName, $userMail, $pass){
    $from = ['contact@monsite.fr' => 'Contact'];
    $to = $userMail;

    $content = "Bonjour ".$userName.", voici votre mot de passe temporaire : ".$pass." Le lien d'accès : http://localhost/P5/Backoffice/index.php A bientôt.";

    $contentHtml = "<p>Bonjour ".$userName."</p><p>Votre mot de passe temporaire : ".$pass."</p><p><a href='http://localhost/P5/Backoffice/index.php'>Lien d'accès</a></p>";

    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
        ->setUsername('d481f137380620')
        ->setPassword('8282c28192de76')
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Bienvenue parmis nous'))
      ->setFrom($from)
      ->setTo($to)
      ->setBody($content, 'text/plain')
      ->addPart($contentHtml, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    return $result;
  }


  /**
   * Profile page
   */
  public function profilepage(){
    ob_start();
    require_once $this->getViewPath().'profile.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }


  /**
  * Call for login page
  * Check if user infos are valid and create session
  */
  public function login(){

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

      // Use Ip
      $ip = $_SERVER['REMOTE_ADDR'];
      $connect = $userManager->connect($ip);

      if($connect < 3)
      {
        if($user->isValid())
        {
          // get user from database with email from form
          $loggingUser = $userManager->getUserByMail($user->email());

          if($loggingUser)
          {
            $passwordCheck = password_verify($user->password(), $loggingUser->password());
            if($passwordCheck)
            {
              // If user is confirmed (has changed his password once)
              if($loggingUser->confirm() == 1)
              {
                session_start();
                $_SESSION['role'] = 'admin';
                $_SESSION['id'] = $loggingUser->id();
                $_SESSION['inputs'] = [];
                header('Location: ?page=home');
              }
              // If user is new and has not changed his password yet
              elseif($loggingUser->confirm() == 0)
              {
                session_start();
                $_SESSION['role'] = 'guest';
                $_SESSION['id'] = $loggingUser->id();
                $_SESSION['inputs'] = [];
                header('Location: ?page=newpass');
              }
            }
            else
            {
              $prohib = "Informations de connection éronées (mdp)";
              $failconnect = $userManager->failconnect($ip, $loggingUser->id());
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


  /**
   * Page to create new password
   */
  public function newpasspage(){
    $db = DBFactory::getPDO();
    $userManager = new UserManager($db);

    $user = $userManager->getUser($_SESSION['id']);

    if($_POST['updatemdp']){
        print_r($user);
    }

    ob_start();
    require_once $this->getViewPath().'newpass.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }


  /**
   * Destroy session when logout
   */
  public function logout(){
    $_SESSION = [];
    session_destroy();
  }

  /**
   * Check if user connected or not
   * @return bool True if there is a role session var
   */
  public function loggedIn($role = null){
    if(isset($_SESSION['role']) && $_SESSION['role'] == $role)
    {
      return true;
    }else {
      return false;
    }
  }


  /**
   * Update comment for checked
   * @param  int $idcomment [description]
   * @param  int $idpost    [description]
   */
  public function updateComment($idcomment, $idpost){
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
  public function flagComment($idcomment, $idpost){
    $db = DBFactory::getPDO();
    $commentManager = new CommentManager($db);
    $commentManager->updateCheck($idcomment, $idpost, 2);

    header('Location: ?page=home');
  }


}
