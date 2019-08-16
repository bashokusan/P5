<?php
session_start();

// Loadtime (see Views/Backend/Sections/footer)
define('LOADTIME', microtime(true));

// Composer autoload
require_once '../vendor/autoload.php';
// Home made autoload
require_once '../Public/autoload.php';

// Path to pages
$viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Backend' . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR;
// Path to template
$templatePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views/Backend/Layout/template.php';

/**
 * Instance of BackendController
 * @var BackendController
 */
$controller = new BackendController($viewPath, $templatePath);

// Hack Protect
$controller->defense($token);

try {

  // If user is logged in as admin
  if($controller->loggedIn('admin'))
  {
    if(!$_GET || $_GET['page'] == 'home')
    {
      $controller->homepage();
    }

    elseif(!empty($_GET['check']) && !empty($_GET['post']))
    {
      $controller->updateComment((int)$_GET['check'], (int)$_GET['post']);
    }

    elseif(!empty($_GET['flag']) && !empty($_GET['post']))
    {
      $controller->flagComment((int)$_GET['flag'], (int)$_GET['post']);
    }

    elseif($_GET['page'] == 'posts')
    {
      $controller->postspage();
    }

    elseif($_GET['page'] == 'edit')
    {
      $controller->editpage();
    }

    elseif($_GET['page'] == 'comments')
    {
      $controller->commentspage();
    }

    elseif($_GET['page'] == 'adminrequest')
    {
      $controller->adminrequestpage();
    }
      elseif($_GET['acceptrequest'])
      {
        $controller->acceptRequest((int)$_GET['acceptrequest']);
        header('Location: ?page=adminrequest');
      }

    elseif($_GET['page'] == 'profile')
    {
      $controller->profilepage();
    }

    elseif($_GET['page'] == 'newpass')
    {
      $controller->newpasspage();
    }

    elseif($_GET['page'] == 'logout')
    {
      $controller->logout();
      header('Location: ?page=login');
    }

    else
    {
      throw new \Exception("Page introuvable");
    }
  }

  // If user is logged in as guest (unconfirmed admin)
  elseif($controller->loggedIn('guest'))
  {
    if($_GET['page'] == 'logout')
    {
      $controller->logout();
      header('Location: ?page=login');
    }
    else
    {
      $controller->newpasspage();
    }
  }

  // If user is not logged in
  elseif(!$controller->loggedIn())
  {
    if(!$_GET['page'] || $_GET['page'] == 'login' || isset($_GET['guest']))
    {
      $controller->login();
    }

    elseif($_GET['page'] == 'request')
    {
      $controller->requestpage();
    }

    else
    {
      $controller->login();
    }
  }

} catch (\Exception $e) {
  $errorMessage = $e->getMessage();
  ob_start();
  require_once $viewPath.'error.php';
  $content = ob_get_clean();
  require $templatePath;
}
