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
  * Call for login page
   */
  public function login(){

    if(isset($_POST['login']))
    {
      $data = [
        'email' => htmlentities($_POST['email']),
        'password' => htmlentities($_POST['password'])
      ];

      $user = new User($data);
      $db = DBFactory::getPDO();
      $userManager = new UserManager($db);
      if($user->isValid())
      {
        session_start();
        $_SESSION['role'] = 'admin';
        header('Location: ?page=home');
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

  public function logout(){
    $_SESSION['role'] = "";
    $this->login();
  }

  /**
   * [loggedIn description]
   * @return bool [description]
   */
  public function loggedIn(){
    if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){
      return true;
    }else {
      return false;
    }
  }

}
