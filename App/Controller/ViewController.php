<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;
use App\Model\Contact;
use App\Controller\ActionController;

class ViewController
{

  public static function home()
  {
    // Gestion des actions
    // Vérifie si il y a un paramètre action
    if(isset($_GET['action']))
    {
      $action = $_GET['action'];

      // Envoyer un message via le formulaire de contact
      // Vérifie si il y a un paramètre action = contact
      if($action === 'contact')
      {
        ActionController::contact();
      }
      else
      {
        throw new Exception("Cette action n'existe pas");
      }

    }
    require_once "../Views/home.php";
  }

  /**
   * Récupère tous les articles et gère la pagination
   * @return [type] [description]
   */
  public static function blog()
  {
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
      $count = (int)PostManager::count()[0];
      $limit = 4;
      $total = ceil($count / $limit);
      if($currentNbr > $total)
      {
        throw new \Exception("Cette page n'existe pas");
      }
      $offset = $limit * ($currentNbr - 1);
      $response = PostManager::showAll($limit, $offset);

      require_once "../Views/blog.php";
  }

  public static function post()
  {
    if(isset($_GET['id']))
    {
      // Vérifie si l'id de l'url est inférieur ou égal au nombre d'article en BDD
      if((int)$_GET['id'] > 0)
      {
        $id = $_GET['id'];
        if(!filter_var($id, FILTER_VALIDATE_INT))
        {
          throw new \Exception("Cette page n'existe pas");
        }
        $id = (int)$id;
        $post = PostManager::showOne($id);
        $comments = CommentManager::showAll($id);

        // Gestion des actions
        // Vérifie si il y a un paramètre action
        if(isset($_GET['action']))
        {
          $action = $_GET['action'];
          // Publier un commentaire
          // Vérifie si il y a un paramètre action = comment et postid
          if ($action === 'comment')
          {
            ActionController::comment();
          }
          else
          {
            throw new Exception("Cette action n'existe pas");
          }
        }

        require_once "../Views/post.php";

      }
      else
      {
        throw new \Exception("Cette page n'existe pas");
      }
    }
    else
    {
      throw new \Exception("Cette page n'existe pas");
    }
  }


  public static function error($e)
  {
    $errorMessage = $e->getMessage();
    require_once "../Views/error.php";
  }


}
