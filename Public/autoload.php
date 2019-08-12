<?php

/**
 * Load Classes from Controllers folder
 */
function autoloadController($classname)
{
  if(file_exists($file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $classname . ".php")){
    require $file;
  }
}

/**
 * Load Classes from Models folder
 */
function autoload($classname)
{
  if(file_exists($file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Models" . DIRECTORY_SEPARATOR . $classname . ".php")){
    require $file;
  }
}

spl_autoload_register('autoloadController');
spl_autoload_register('autoload');
