<?php
// Chargement du loadtime
define('LOADTIME', microtime(true));


// Composer autoload
require_once '../vendor/autoload.php';


// Whoops library, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


use App\Helpers;
use App\Controller\ViewController;
use App\Controller\ActionController;

ob_start();

$pageToLoad = scandir('../Views');

try {

  // Gestion des views
  // Vérifie si on est sur la racine
  if($_SERVER['REQUEST_URI'] === '/P5/Public/index.php' || $_SERVER['REQUEST_URI'] === '/P5/Public/')
  {
    ViewController::home();
  }
  // Vérifie si le get page correspond à un des fichiers dans le dossier Views
  elseif(in_array($_GET['page'] . '.php', $pageToLoad))
  {
    $view = $_GET['page'];
    ViewController::$view();
  }


  // Gestion des actions
  // Vérifie si il y a un paramètre action
  elseif(isset($_GET['action']))
  {
    $action = $_GET['action'];

    // Publier un commentaire
    // Vérifie si il y a un paramètre action = comment et postid
    if ($action === 'comment')
    {
      ActionController::comment();
    }

    // Envoyer un message via le formulaire de contact
    // Vérifie si il y a un paramètre action = contact
    elseif($action === 'contact')
    {
      ActionController::contact();
    }

    else
    {
      throw new Exception("Cette action n'existe pas");
    }

  }

  else
  {
    throw new Exception("Cette page n'existe pas");
  }


} catch (\Exception $e) {
  ViewController::error($e);
}

$content = ob_get_clean();

$menu = Helpers::menu();

require_once dirname(__DIR__) . "/views/layout/default.php";
