<?php

namespace App;

class Helpers
{
  private function menuItem(string $page, string $title) :string
  {
    $class = "";
    if($_GET['page'] === $page){
        $class = "class='active'";
    };
    return "<li><a href='?page=".$page."'".$class.">".$title."</a></li>";
  }

  public static function menu() : string
  {
    return static::menuItem('home', 'Mon site') .
          static::menuItem('blog', 'Blog');
  }

}
