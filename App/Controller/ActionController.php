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
    if(isset($_GET['id']))
    {
      $id = (int)$_GET['id'];

      if(!empty($_POST['author']) && !empty($_POST['comment']))
      {
        $author = htmlentities($_POST['author']);
        $comment = htmlentities($_POST['comment']);

        $response = CommentManager::postComment($author, $comment, $id);
        if($response)
        {
          header("Location:?page=post&id=$id");
        }
        else
        {
          $error = "Une erreur est survenue";
        }
      }
      else
      {
        $error = "tous les champs doivent être remplis";
      }
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
          header('Location:?page=home');
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

  }

}
