<?php
session_start();

// Loadtime (see Views/Backend/Sections/footer)
define('LOADTIME', microtime(true));

// Composer autoload
require_once '../vendor/autoload.php';

use App\Controllers\Controller;
use App\Controllers\Backend\Homepage;
use App\Controllers\Backend\PostsList;
use App\Controllers\Backend\EditPost;
use App\Controllers\Backend\CommentsPage;
use App\Controllers\Backend\RequestsList;
use App\Controllers\Backend\Profile;
use App\Controllers\Backend\NewPass;
use App\Controllers\Backend\Auth;
use App\Controllers\Backend\Logout;
use App\Controllers\Backend\RequestPage;
use App\Controllers\Backend\ResetPass;

// Path to pages
$viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Backend' . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR;
// Path to template
$templatePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views/Backend/Layout/template.php';

/**
 * Instance of BackendController
 * @var Controller
 */
$controller = new Controller($viewPath, $templatePath);

// Session hijacking defense
$controller->sessionHijack();

// CSRF defense
$controller->csrf();

try {
    // If user is logged in as admin
    if ($controller->loggedIn('admin')) {
        if (!$_GET || (isset($_GET['page']) && $_GET['page'] === 'home')) {
            $homepage = new Homepage($viewPath, $templatePath);
            $homepage->homepage();
        } elseif (!empty($_GET['check']) && !empty($_GET['post'])) {
            if (!filter_var($_GET['check'], FILTER_VALIDATE_INT) || !filter_var($_GET['post'], FILTER_VALIDATE_INT)) {
                throw new \Exception("Cette page n'existe pas");
            } else {
                $homepage = new Homepage($viewPath, $templatePath);
                $homepage->updateComment((int)$_GET['check'], (int)$_GET['post']);
            }
        } elseif (!empty($_GET['flag']) && !empty($_GET['post'])) {
            if (!filter_var($_GET['flag'], FILTER_VALIDATE_INT) || !filter_var($_GET['post'], FILTER_VALIDATE_INT)) {
                throw new \Exception("Cette page n'existe pas");
            } else {
                $homepage = new Homepage($viewPath, $templatePath);
                $homepage->flagComment((int)$_GET['flag'], (int)$_GET['post']);
            }
        } elseif (isset($_GET['page']) && $_GET['page'] === 'posts') {
            $posts = new PostsList($viewPath, $templatePath);
            $posts->postsPage();
        } elseif (!empty($_GET['delete'])) {
            if (!filter_var($_GET['delete'], FILTER_VALIDATE_INT)) {
                throw new \Exception("Cette page n'existe pas");
            } else {
                $posts = new PostsList($viewPath, $templatePath);
                $posts->deletePost((int)$_GET['delete']);
            }
        } elseif (isset($_GET['page']) && $_GET['page'] === 'edit') {
            $editPost = new EditPost($viewPath, $templatePath);
            $editPost->editPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'comments') {
            $comments = new CommentsPage($viewPath, $templatePath);
            $comments->commentsPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'adminrequest') {
            $requests = new RequestsList($viewPath, $templatePath);
            $requests->adminRequestPage();
        } elseif (isset($_GET['acceptrequest'])) {
            if (!filter_var($_GET['acceptrequest'], FILTER_VALIDATE_INT)) {
                throw new \Exception("Cette page n'existe pas");
            } else {
                $acceptRequest = new RequestsList($viewPath, $templatePath);
                $acceptRequest->acceptRequest((int)$_GET['acceptrequest']);
            }

            header('Location: ?page=adminrequest');
        } elseif (isset($_GET['page']) && $_GET['page'] === 'profile') {
            $profile = new Profile($viewPath, $templatePath);
            $profile->profilePage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'newpass') {
            $newpass = new NewPass($viewPath, $templatePath);
            $newpass->newPassPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'logout') {
            $logout = new Logout();
            $logout->logout();
        } else {
            throw new \Exception("Page introuvable");
        }
    }

    // If user is logged in as guest (unconfirmed admin)
    elseif ($controller->loggedIn('guest')) {
        if (isset($_GET['page']) && $_GET['page'] === 'logout') {
            $logout = new Logout();
            $logout->logout();
        } else {
            $newpass = new NewPass($viewPath, $templatePath);
            $newpass->newPassPage();
        }
    }

    // If user is not logged in
    elseif (!$controller->loggedIn()) {
        if (!$_GET['page'] || (isset($_GET['page']) && $_GET['page'] === 'login') || isset($_GET['guest'])) {
            $login = new Auth($viewPath, $templatePath);
            $login->login();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'resetpass') {
            $resetPass = new ResetPass($viewPath, $templatePath);
            $resetPass->resetPass();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'reset') {
            // In url from the email sent after reset request
            if (isset($_GET['restoken']) && isset($_GET['validator'])&& !empty($_GET['restoken']) && !empty($_GET['validator'])) {
                if (ctype_xdigit($_GET['restoken']) && ctype_xdigit($_GET['validator'])) {
                    $newpass = new NewPass($viewPath, $templatePath);
                    $newpass->newPassPage();
                }
            } else {
                $login = new Auth($viewPath, $templatePath);
                $login->login();
            }
        } elseif (isset($_GET['page']) && $_GET['page'] === 'request') {
            $request = new RequestPage($viewPath, $templatePath);
            $request->requestPage();
        } else {
            $login = new Auth($viewPath, $templatePath);
            $login->login();
        }
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();
    ob_start();
    require_once $viewPath.'error.php';
    $content = ob_get_clean();
    require $templatePath;
}
