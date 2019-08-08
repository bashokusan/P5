<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;
use App\Model\Contact;

class ActionController
{

  /**
   * Vérifie l'url et appel la fonction postComment de la class CommentManager
   * @return [type] [description]
   */
  public static function comment()
  {
    if(isset($_GET['postid']) && (int)$_GET['postid'] <= (int)PostManager::count()[0])
    {
      if(!empty($_POST['author']) && !empty($_POST['comment']))
      {
        $author = htmlentities($_POST['author']);
        $comment = htmlentities($_POST['comment']);
        $id = (int)$_GET['postid'];

        $response = CommentManager::postComment($author, $comment, $id);
        if(!$response)
        {
          $error = "Une erreur est survenue";
        }
      }
      else
      {
        $error = "tous les champs doivent être remplis";
      }
      header('Location: ?page=post&id='.(int)$_GET['postid']);
    }
    else
    {
      $error = "Les paramètres sont invalides";
    }
  }

  /**
   * Vérifie l'url et instancie la class Contact pour envoyer le message
   * @return [type] [description]
   */
  public static function contact()
  {
    if(!empty($_POST['name']) && !empty($_POST['email'])  && !empty($_POST['message']))
    {
      $name = htmlentities($_POST['name']);
      $email = htmlentities($_POST['email']);
      $message = htmlentities($_POST['message']);

      if(filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $message = new Contact($name, $email, $message);
        $message->sendMessage();

        if($message)
        {
          $success =  "votre message à bien été envoyé, vous allez recevoir une copie par email";
        }
        else
        {
          $error = "Une erreur est survenue";
        }
      }
      else
      {
        $error = "email invalide";
      }
    }
    else
    {
      $error = "tous les champs doivent être remplis";
    }

    header('Location: ?page=home');
  }

}
