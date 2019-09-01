<?php
session_start();

// Composer autoload
require_once '../vendor/autoload.php';

use App\Controllers\Frontend\FrontendController;

/**
 * Instance of FrontendController
 * @var FrontendController
 */
$controller = new FrontendController();

try {
    if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] === 'home')) {
        $controller->home();
    } elseif (isset($_GET['page']) && $_GET['page'] === 'blog') {
        $controller->blog();
    } elseif (isset($_GET['page']) && $_GET['page'] === 'article' && !empty($_GET['id'])) {
        if (!filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            throw new \Exception("Cette page n'existe pas");
        } else {
            $controller->post((int)$_GET['id']);
        }
    } else {
        throw new \Exception("Cette page n'existe pas");
    }
} catch (\Exception $e) {
    $errorMessage = $e->getMessage();
    ob_start();
    require_once '../Views/Backend/Pages/error.php';
    $content = ob_get_clean();
    require '../Views/Backend/Layout/template.php';
}
