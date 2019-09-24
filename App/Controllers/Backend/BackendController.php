<?php

namespace App\Controllers\Backend;

use App\Controllers\DBFactory;

/**
 * Parent Controller for Backend and Frontend Controllers
 */
class BackendController
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var string
     */
    private $templatePath;

    /**
     * @var DBFactory
     */
    private $db;

    public function __construct()
    {
        $this->setViewPath('../Views/Backend/Pages/');
        $this->setTemplatePath('../Views/Backend/Layout/template.php');
        $this->setDb(DBFactory::getPDO());
    }

    // Setters
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

    // Getters
    public function getDb()
    {
        return $this->db;
    }

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
        $_COOKIE['u_log'] = $token;
        $_SESSION['u_log'] = $token;

        if ($_COOKIE['u_log'] == $_SESSION['u_log'])
        {
          $token = bin2hex(random_bytes(32));
          setcookie('u_log', $token, time() + (60 * 20));
          $_COOKIE['u_log'] = $token;
          $_SESSION['u_log'] = $token;
        }
        else
        {
          $_SESSION = [];
          session_destroy();
          header('location:index.php');
        }
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
