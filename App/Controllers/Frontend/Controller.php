<?php

namespace App\Controllers\Frontend;

use App\Models\DBFactory;

/**
 * Parent Controller for Backend and Frontend Controllers
 */
abstract class Controller
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

    /**
     * @param string $viewPath     [description]
     * @param string $templatePath [description]
     */
    public function __construct($viewPath, $templatePath)
    {
        $this->setViewPath($viewPath);
        $this->setTemplatePath($templatePath);
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
}
