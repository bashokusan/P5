<?php

// Chargement du loadtime
define('LOADTIME', microtime(true));

// Composer autoload
require_once '../vendor/autoload.php';
require_once 'autoload.php';

// Whoops library, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Frontend' . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR;

$templatePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views/Frontend/Layout/template.php';


$controller = new FrontendController($viewPath, $templatePath);


if(!isset($_GET['page']) || $_GET['page'] == 'home')
{
  $controller->home();
}

elseif ($_GET['page'] == 'blog')
{
  $controller->blog();
}

elseif ($_GET['page'] == 'article' && isset($_GET['id']))
{
  $controller->post((int)$_GET['id']);
}
