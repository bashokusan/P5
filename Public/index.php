<?php
// Composer autoload
require_once '../vendor/autoload.php';


// Whoops library, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


use App\Database;
use App\Helpers;
use App\model\PostManager;


// Routeur
ob_start();

if($_GET['page'] === 'home' || !$_GET || empty($_GET['page']))
{
  require_once "../Views/home.php";
}

elseif($_GET['page'] === 'blog')
{
  $response = PostManager::showAll();

  require_once "../Views/blog.php";
}

elseif($_GET['page'] == 'post' && isset($_GET['id']))
{
  if((int)$_GET['id'] <= (int)PostManager::count()[0]){
    $response = PostManager::showOne($_GET['id']);

    require_once "../Views/post.php";
  }
  else{
    require_once "../Views/notFound.php";
  }

}

else
{
  require_once "../Views/notFound.php";
}

$content = ob_get_clean();

$menu = Helpers::menu();

require_once "../views/layout/default.php";
