<?php

/**
 * Parent Controller for Backend and Frontend Controllers
 */
abstract class Controller
{

  protected $viewPath;
  protected $templatePath;
  protected $token;


  /**
   * Set the viewPath and templatePath
   * @param string $viewPath     Path to pages
   * @param string $templatePath Path to template
   * @param string $token Token
   */
  public function __construct($viewPath, $templatePath){
    $this->setViewPath($viewPath);
    $this->setTemplatePath($templatePath);
  }


  // Setters
  public function setViewPath($viewPath){
    $this->viewPath = $viewPath;
  }

  public function setTemplatePath($templatePath){
    $this->templatePath = $templatePath;
  }

  public function setToken($token){
    $this->token = $token;
  }

  // Getters
  public function getViewPath(){
    return $this->viewPath;
  }

  public function getTemplatePath(){
    return $this->templatePath;
  }

  public function getToken(){
    return $this->token;
  }

}
