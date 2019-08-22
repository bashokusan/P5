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


// Session hijacking defense
$controller->sessionHijack();

// CSRF defense
$controller->csrf();

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
      $controller->postsPage();
    }

    elseif(!empty($_GET['delete']))
    {
      $controller->deletePost((int)$_GET['delete']);
    }

    elseif($_GET['page'] == 'edit')
    {
      $controller->editPage();
    }

    elseif($_GET['page'] == 'comments')
    {
      $controller->commentsPage();
    }

    elseif($_GET['page'] == 'adminrequest')
    {
      $controller->adminRequestPage();
    }
      elseif($_GET['acceptrequest'])
      {
        $controller->acceptRequest((int)$_GET['acceptrequest']);
        header('Location: ?page=adminrequest');
      }

    elseif($_GET['page'] == 'profile')
    {
      $controller->profilePage();
    }

    elseif($_GET['page'] == 'newpass')
    {
      $controller->newPassPage();
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
      $controller->newPassPage();
    }
  }

  // If user is not logged in
  elseif(!$controller->loggedIn())
  {
    if(!$_GET['page'] || $_GET['page'] == 'login' || isset($_GET['guest']))
    {
      $controller->login();
    }

    elseif($_GET['page'] == 'resetpass')
    {
      $controller->resetPassPage();
    }

    elseif($_GET['page'] == 'reset')
    {
      // In url from the email sent after reset request
      if(isset($_GET['restoken']) && isset($_GET['validator'] )&& !empty($_GET['restoken']) && !empty($_GET['validator'])){
        if(ctype_xdigit($_GET['restoken']) && ctype_xdigit($_GET['validator'])){
          $controller->newPassPage();
        }
      }
      else{
        $controller->login();
      }

    }

    elseif($_GET['page'] == 'request')
    {
      $controller->requestPage();
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
