<?php

namespace App\Controllers\Frontend;

/**
 * Parent Controller for Backend and Frontend Controllers
 */
class Controller
{
    /**
     * @var string
     */
    private $viewPath = '../Views/Frontend/Pages/';
    /**
     * @var string
     */
    private $templatePath = '../Views/Frontend/Layout/template.php';


    // Getters
    public function getViewPath()
    {
        return $this->viewPath;
    }

    public function getTemplatePath()
    {
        return $this->templatePath;
    }


    /**
     * Check if user connected or not
     * @param  string $role [description]
     * @return bool True if there is a role session var
     */
    public function loggedIn($role = null)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == $role) {
            return true;
        } else {
            return false;
        }
    }


    //------------------------------------------------------------------------------
    // Hack Defense Methods
    //------------------------------------------------------------------------------
    /**
     * Session hijacking defense function
     */
    public function sessionHijack()
    {
        $token = bin2hex(random_bytes(32));
        setcookie('u_log', $token, time() + (60 * 20));
        $_SESSION['u_log'] = $token;
    }


    /**
     * CSRF defense function
     * If token in url different from token in session, logout user
     */
    public function csrf()
    {
        if (isset($_GET['token']) && !empty($_GET['token'])) {
            // If token in url is different from token in session and cookie, session is destroyed
            if ($_GET['token'] != $_SESSION['t_user']) {
                $_SESSION = [];
                session_destroy();
                header('location:index.php');
            }
        }

        if (isset($_POST['t_user']) && !empty($_POST['t_user'])) {
            if ($_POST['t_user'] != $_SESSION['t_user']) {
                $_SESSION = [];
                session_destroy();
                header('location:index.php');
            }
        }
    }
}
