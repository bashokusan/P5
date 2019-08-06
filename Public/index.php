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

// Routeur
ob_start();

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

  elseif($page == 'post' && isset($_GET['id']))
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
      echo "id invalide";
    }
  }
  else
  {
    echo "page introuvable";
  }

}

else
{
  echo "cette page n'existe pas";
}

$content = ob_get_clean();

$menu = Helpers::menu();

require_once "../views/layout/default.php";
