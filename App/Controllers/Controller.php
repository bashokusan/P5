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

  /**
   * Render page with its data
   * @param  string $page Page to display
   * @param  array  $data Data of the page
   */
  public function render($page, array $data){
    extract($data);

    ob_start();
    require_once $this->getViewPath().$page.'.php';
    $content = ob_get_clean();
    require $this->getTemplatePath();
  }

}
