<?php

/**
 * Class for random but useful functions.
 */
class Helpers
{

  /**
   * Create <li> item for the menu
   * @param  string $page  Target page
   * @param  string $name Name of the page
   * @return string        Return the <li> with link to the page
   */
  private function menuItem(string $page, string $name) :string
  {
    $class = "";
    if($_GET['page'] === $page){
        $class = "class='active'";
    };
    return "<li><a href='?page=".$page."'".$class.">".$name."</a></li>";
  }

  /**
   * @return string Return all the <li> for the menu
   */
  public static function menu() : string
  {
    return static::menuItem('home', 'About')
        . static::menuItem('blog', 'Blog');
  }

}
