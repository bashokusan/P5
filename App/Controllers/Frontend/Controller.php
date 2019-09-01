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

}
