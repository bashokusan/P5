<?php

function autoloadController($classname)
{
  if(file_exists($file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $classname . ".php")){
    require $file;
  }
}

function autoload($classname)
{
  if(file_exists($file = dirname(__DIR__) . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Models" . DIRECTORY_SEPARATOR . $classname . ".php")){
    require $file;
  }
}

spl_autoload_register('autoloadController');
spl_autoload_register('autoload');
