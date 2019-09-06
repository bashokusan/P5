<?php
session_start();

// Loadtime (see Views/Backend/Sections/footer)
define('LOADTIME', microtime(true));

// Composer autoload
require_once '../vendor/autoload.php';

use App\Controllers\Backend\BackendController;
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

/**
 * Instance of BackendController
 * @var BackendController
 */
$controller = new BackendController();
// Session hijacking defense
$controller->sessionHijack();
// CSRF defense
$controller->csrf();

try {
    // If user is logged in as admin
    if ($controller->loggedIn('admin')) {
        if (!$_GET || (isset($_GET['page']) && $_GET['page'] === 'home')) {
            $homepage = new Homepage();
            $homepage->homepage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'posts') {
            $posts = new PostsList();
            $posts->postsPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'edit') {
            $editPost = new EditPost();
            $editPost->editPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'comments') {
            $comments = new CommentsPage();
            $comments->commentsPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'adminrequest') {
            $requests = new RequestsList();
            $requests->adminRequestPage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'profile') {
            $profile = new Profile();
            $profile->profilePage();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'newpass') {
            $newpass = new NewPass();
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
            $newpass = new NewPass();
            $newpass->newPassPage();
        }
    }
    // If user is not logged in
    elseif (!$controller->loggedIn()) {
        if (!$_GET['page'] || (isset($_GET['page']) && $_GET['page'] === 'login') || isset($_GET['guest'])) {
            $login = new Auth();
            $login->login();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'resetpass') {
            $resetPass = new ResetPass();
            $resetPass->resetPass();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'reset') {
            // In url from the email sent after reset request
            if (isset($_GET['restoken']) && isset($_GET['validator']) && !empty($_GET['restoken']) && !empty($_GET['validator'])) {
                if (ctype_xdigit($_GET['restoken']) && ctype_xdigit($_GET['validator'])) {
                    $newpass = new NewPass();
                    $newpass->newPassPage();
                }
            } else {
                $login = new Auth();
                $login->login();
            }
        } elseif (isset($_GET['page']) && $_GET['page'] === 'request') {
            $request = new RequestPage();
            $request->requestPage();
        } else {
            throw new \Exception("Page introuvable");
        }
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();
    ob_start();
    require_once '../Views/Backend/Pages/error.php';
    $content = ob_get_clean();
    require_once '../Views/Backend/Layout/template.php';
}
