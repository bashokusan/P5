<?php

// Loadtime (see Views/Frontent/Sections/footer)
define('LOADTIME', microtime(true));

// Composer autoload
require_once '../vendor/autoload.php';
// Home made autoload
require_once 'autoload.php';

// Whoops library, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Path to pages
$viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Frontend' . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR;
// Path to template
$templatePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views/Frontend/Layout/template.php';

/**
 * Instance of FrontendController
 * @var FrontendController
 */
$controller = new FrontendController($viewPath, $templatePath);

try {

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

  else
  {
    throw new \Exception("Cette page n'existe pas");
  }

} catch (\Exception $e) {
  $errorMessage = $e->getMessage();
  ob_start();
  require_once $viewPath.'error.php';
  $content = ob_get_clean();
  require $templatePath;
}
