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
   * Call for home page
   */
  public function home(){
    ob_start();
    require_once $this->getViewPath().'home.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }

  /**
   * Page to request admin role
   * Save email and message from request form into the database
   */
  public function request(){

    if($_POST['request'])
    {
      $data = [
        'name' => htmlentities($_POST['name']),
        'email' => htmlentities($_POST['email']),
        'message' => htmlentities($_POST['message'])
      ];

      $user = new User($data);
      $db = DBFactory::getPDO();
      $userManager = new UserManager($db);

      if($user->isValid())
      {
        $userManager->add($user);
        $message = "Votre demande a bien été envoyé";
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
   * Call in requests page
   */
  public function answerRequest(){

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
   * Call when accept link on requests page
   */
  public function acceptRequest($id){
    $token = bin2hex(random_bytes(64));
    $pass = rand(10000, 99999);
    $hashPass = password_hash($pass, PASSWORD_DEFAULT);

    $db = DBFactory::getPDO();
    $userManager = new UserManager($db);
    $user = $userManager->getUser($id);

    $userManager->acceptRequest($id, $hashPass, $token);

    $this->sendAnswer($user->name(), $user->email(), $pass, $token);
  }

  /**
   * Send email to new user (see above)
   * @param  string $userName
   * @param  string $userMail
   * @param  string $pass
   * @param  string $token
   * @return bool
   */
  public function sendAnswer($userName, $userMail, $pass, $token){
    $from = ['contact@monsite.fr' => 'Contact'];
    $to = $userMail;

    $content = "Bonjour ".$userName.", voici votre mot de passe temporaire : ".$pass." Le lien d'accès : http://localhost/P5/Backoffice/index.php?guest=".$token." A bientôt.";

    $contentHtml = "<p>Bonjour ".$userName."</p><p>Votre mot de passe temporaire : ".$pass."</p><p><a href='http://localhost/P5/Backoffice/index.php?guest=".$token."'>Lien d'accès</a></p>";

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
      $user = new User($data);

      if($user->isValid())
      {
        $db = DBFactory::getPDO();
        $userManager = new UserManager($db);

        $loggingUser = $userManager->getUserByMail($user->email());
        if($loggingUser){
          $passwordCheck = password_verify($user->password(), $loggingUser->password());
          if($passwordCheck)
          {
            session_start();
            $_SESSION['role'] = 'admin';
            $_SESSION['token'] = $loggingUser->token();
            header('Location: ?page=home');
          }
          else
          {
            $prohib = "Informations de connection éronées (mdp)";
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

    ob_start();
    require_once $this->getViewPath().'login.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

  }

  /**
   * Destroy session when logout
   */
  public function logout(){
    $_SESSION['role'] = "";
    $_SESSION['token'] = "";
    session_destroy();
  }

  /**
   * Check if user connected or not
   * @return bool True if var session
   */
  public function loggedIn(){
    if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
      return true;
    }else {
      return false;
    }
  }

}
