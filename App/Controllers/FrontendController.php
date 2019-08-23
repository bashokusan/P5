<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\DBFactory;
use App\Models\Message;
use App\Models\MessageManager;
use App\Models\Post;
use App\Models\PostManager;
use App\Models\Comment;
use App\Models\CommentManager;

/**
 * Main controller, action to do when called by the router
 */
class FrontendController extends Controller
{

//------------------------------------------------------------------------------
// METHODS
//------------------------------------------------------------------------------

//------------------------------------------------------------------------------
// Home Page Methods
//------------------------------------------------------------------------------
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

      $name = htmlspecialchars($_POST['name']);
      $email = htmlspecialchars($_POST['email']);
      $messageContent = htmlspecialchars($_POST['message']);

      $data = [
        'name' => $name,
        'email' => $email,
        'message' => $messageContent,
      ];

      $_SESSION['inputs'] = $_POST;

      $newMessage = new Message($data);

      if($newMessage->isValid()){
        $messageManager = new MessageManager;
        ;
        if ($messageManager->send($newMessage))
        {
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
    require_once $this->getTemplatePath();

    $_SESSION['inputs'] = [];
  }


//------------------------------------------------------------------------------
// Blog Page Methods
//------------------------------------------------------------------------------
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

    if(isset($_GET['p'])){
      $currentNbr = (int)$_GET['p'];
    }
    else
    {
      $currentNbr = 1;
    }
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
    require_once $this->getTemplatePath();
  }


//------------------------------------------------------------------------------
// Unique Post Page Methods
//------------------------------------------------------------------------------
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
      $author = htmlspecialchars($_POST['author']);
      $content = htmlspecialchars($_POST['content']);
      $data = [
        'idArticle' => $id,
        'author' => $author,
        'content' => $content,
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
    require_once $this->getTemplatePath();

    $_SESSION['inputs'] = [];
  }

}
