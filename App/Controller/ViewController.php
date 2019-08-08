<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;
use App\Model\Contact;

class ViewController
{

  public static function home()
  {
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
      if((int)$_GET['id'] > 0 && (int)$_GET['id'] <= (int)PostManager::count()[0])
      {
        $id = $_GET['id'];
        if(!filter_var($id, FILTER_VALIDATE_INT))
        {
          throw new \Exception("Cette page n'existe pas");
        }
        $id = (int)$id;
        $response = PostManager::showOne($id);
        $comments = CommentManager::showAll($id);

        require_once "../Views/post.php";

      }
      else
      {
        throw new \Exception("Cette page n'existe pas");
      }
    }
    else
    {
      throw new Exception("Cette page n'existe pas");
    }
  }


  public static function error($e)
  {
    $errorMessage = $e->getMessage();
    require_once "../Views/error.php";
  }

}
