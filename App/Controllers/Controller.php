<?php

namespace App\Controllers;

/**
 * Parent Controller for Backend and Frontend Controllers
 */
abstract class Controller
{
    protected $viewPath;
    protected $templatePath;

    /**
     * Set the viewPath and templatePath
     * @param string $viewPath     Path to pages
     * @param string $templatePath Path to template
     */
    public function __construct($viewPath, $templatePath)
    {
        $this->setViewPath($viewPath);
        $this->setTemplatePath($templatePath);
    }


    // Setters

    /**
     * @param string $viewPath [description]
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    /**
     * @param string $templatePath [description]
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    // Getters
    public function getViewPath()
    {
        return $this->viewPath;
    }

    public function getTemplatePath()
    {
        return $this->templatePath;
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
