<?php

/**
 * Main controller, action to do when called by the router
 */
class FrontendController
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
   * Actions when in home page :
   *
   * New object Message is created with data from contact form.
   * Send function in MessageManager will send the object.
   *
   * Require content of the page.
   */
  public function home(){

    if(isset($_POST['send'])){
      $data = [
        'name' => htmlentities($_POST['name']),
        'email' => htmlentities($_POST['email']),
        'message' => htmlentities($_POST['message']),
      ];

      $_SESSION['inputs'] = $_POST;

      $newMessage = new Message($data);

      if($newMessage->isValid()){
        $messageManager = new MessageManager;
        ;
        if ($messageManager->send($newMessage)) {
          $message = 'Votre message a bien été envoyé.';
          $_SESSION['inputs'] = [];
        }else {
          $message = 'Une erreur est survenue.';
        }

      }else {
        $errors = $newMessage->errors();
      }

    }

    ob_start();
    require_once $this->getViewPath().'home.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

    $_SESSION['inputs'] = [];
  }


  /**
   * Actions when in blog page :
   *
   * Call PDO and create an object PostManager
   * Handle pagination
   * Call list of posts with getList function
   *
   * Require content of the page.
   */
  public function blog(){

    $db = DBFactory::getPDO();
    $postManager = new PostManager($db);

    $currentNbr = $_GET['p'] ?? 1;
    if(!filter_var($currentNbr, FILTER_VALIDATE_INT))
    {
      throw new \Exception("Cette page n'existe pas");
    }
    $currentNbr = (int)$currentNbr;
    if($currentNbr <= 0)
    {
      throw new \Exception("Cette page n'existe pas");
    }
    $count = (int)$postManager->count();
    $limit = 6;
    $total = ceil($count / $limit);
    if($currentNbr > $total)
    {
    throw new \Exception("Cette page n'existe pas");
    }
    $offset = $limit * ($currentNbr - 1);


    $postList = $postManager->getList($limit, $offset);

    ob_start();
    require_once $this->getViewPath() .'blog.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }


  /**
   * Action when in post page :
   *
   * Get the post with id in param.
   * Create object Comment with data from comment form.
   * Check if data are valid to send the comment with CommentManager object.
   *
   * Require content of the page.
   *
   * @param  int $id article id from get
   */
  public function post($id){
    $db = DBFactory::getPDO();
    $manager = new PostManager($db);
    $post = $manager->getUnique($id);
    $commentManager = new CommentManager($db);

    if(isset($_POST['add'])){
      $data = [
        'idArticle' => $id,
        'author' => htmlentities($_POST['author']),
        'content' => htmlentities($_POST['content']),
      ];

      $_SESSION['inputs'] = $_POST;

      $newComment = new Comment($data);

      if($newComment->isValid()){
        $commentManager->save($newComment);
        $_SESSION['inputs'] = [];
        $message = "Votre commentaire à bien été envoyé. Il sera vérifié avant d'être mis en ligne";
      }else {
        $errors = $newComment->errors();
      }

    }
    /*
     * Call for getList function in CommentManager
     * Params for function : id article, type of comment (null for all, checked for 'checked' comments only, 'unchecked' for unchecked comments only)
     */
    $listofcomments = $commentManager->getList($post->id(), 'checked');

    ob_start();
    require_once $this->getViewPath() .'post.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();

    $_SESSION['inputs'] = [];
  }

}
