<?php
// Chargement du loadtime
define('LOADTIME', microtime(true));

// Composer autoload
require_once '../vendor/autoload.php';


// Whoops library, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


use App\Database;
use App\Helpers;
use App\model\PostManager;
use App\model\CommentManager;
use App\model\Contact;

// Routeur
ob_start();

// Prépare les success et errors
$success;
$error;

// Vérifie si on est sur la racine
if($_SERVER['REQUEST_URI'] === '/P5/Public/index.php')
{
  require_once "../Views/home.php";
}

// Vérifie si il y a un paramètre page
elseif(isset($_GET['page']))
{
  $page = htmlentities($_GET['page']);

  if($page === 'home')
  {
    require_once "../Views/home.php";
  }

  elseif($page === 'blog')
  {
    $response = PostManager::showAll();
    require_once "../Views/blog.php";
  }

  elseif($page === 'post' && isset($_GET['id']))
  {
    // Vérifie si l'id de l'url est inférieur ou égal au nombre d'article en BDD
    if(((int)$_GET['id']) &&  (int)$_GET['id'] <= (int)PostManager::count()[0])
    {
      $response = PostManager::showOne($_GET['id']);
      $comments = CommentManager::showAll($_GET['id']);

      require_once "../Views/post.php";
    }
    else
    {
      $error = "id invalide";
    }
  }
  else
  {
    $errors = "page introuvable";
  }

}

// Publier un commentaire
// Vérifie si il y a un paramètre action = post et postid
elseif (isset($_GET['action']) && $_GET['action'] === 'comment'
    && isset($_GET['postid']) && (int)$_GET['postid'] <= (int)PostManager::count()[0])
{
  if(!empty($_POST['author']) && !empty($_POST['comment']))
  {
    $author = htmlentities($_POST['author']);
    $comment = htmlentities($_POST['comment']);
    $response = CommentManager::postComment($author, $comment, (int)$_GET['postid']);
    if($response)
    {
      header('Location: ?page=post&id='.(int)$_GET['postid']);
    }
    else{
      $error = "commentaire non ajouté";
    }
  }
  else
  {
    $error =  "tous les champs doivent être remplis";
  }
}

// Envoyer un message via le formulaire de contact
// Vérifie si il y a un paramètre action = contact
elseif(isset($_GET['action']) && $_GET['action'] === 'contact')
{
  if(!empty($_POST['name']) && !empty($_POST['email'])  && !empty($_POST['message']))
  {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $message = htmlentities($_POST['message']);

    $message = new Contact($name, $email, $message);
    $message->sendMessage();

    if($message)
    {
      $success =  "votre message à bien été envoyé";
    }
    else
    {
      $error = "un erreur est survenue";
    }
  }
  else
  {
    $error = "tous les champs doivent être remplis";
  }
}

else
{
  $error = "cette page n'existe pas";
}

$content = ob_get_clean();

$menu = Helpers::menu();

require_once "../views/layout/default.php";
