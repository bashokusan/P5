<?php
// Composer autoload
require_once '../vendor/autoload.php';

use App\Database;
use App\Post;

// Whoops library, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


// Routeur
ob_start();
if($_GET['page'] === 'blog')
{
  $response = Post::showAll();

  require_once "../Views/blog.php";
}
elseif($_GET['page'] == 'post' && isset($_GET['id']))
{
  $response = Post::showOne($_GET['id']);

  require_once "../Views/post.php";
}
elseif($_GET['page'] === 'home')
{
  require_once "../Views/home.php";
}
else
{
  require_once "../Views/home.php";
}
$content = ob_get_clean();

require_once "../views/layout/default.php";
