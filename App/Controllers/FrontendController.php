<?php

/**
 *
 */
class FrontendController
{

  private $viewPath;
  private $templatePath;

  public function __construct($viewPath, $templatePath){
    $this->setViewPath($viewPath);
    $this->setTemplatePath($templatePath);
  }

  public function setViewPath($viewPath){
    $this->viewPath = $viewPath;
  }

  public function setTemplatePath($templatePath){
    $this->templatePath = $templatePath;
  }

  public function getViewPath(){
    return $this->viewPath;
  }

  public function getTemplatePath(){
    return $this->templatePath;
  }


  public function home(){

    if(isset($_POST['send'])){
      $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'message' => $_POST['message'],
      ];

      $newMessage = new Message($data);

      if($newMessage->isValid()){
        $messageManager = new MessageManager;
        ;
        if ($messageManager->send($newMessage)) {
          $message = 'Message envoyé';
        }else {
          $message = 'une erreur est survenue';
        }

      }else {
        $errors = $newMessage->errors();
      }

    }

    $menu = Helpers::menu();
    ob_start();
    require_once $this->getViewPath().'home.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }

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

    $menu = Helpers::menu();
    ob_start();
    require_once $this->getViewPath() .'blog.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }

  public function post($id){
    $db = DBFactory::getPDO();
    $manager = new PostManager($db);
    $post = $manager->getUnique($id);
    $commentManager = new CommentManager($db);

    if(isset($_POST['add'])){
      $data = [
        'idArticle' => $id,
        'author' => $_POST['author'],
        'content' => $_POST['content'],
      ];

      $newComment = new Comment($data);

      if($newComment->isValid()){
        $commentManager->save($newComment);
        $message = "Votre commentaire à bien été envoyé. Il sera vérifié avant d'être mis en ligne";
      }else {
        $errors = $newComment->errors();
      }

    }

    $menu = Helpers::menu();
    ob_start();
    require_once $this->getViewPath() .'post.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }

}
