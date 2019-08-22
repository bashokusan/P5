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
  public static function menuFront() : string
  {
    return static::menuItem('home', 'About')
        . static::menuItem('blog', 'Blog');
  }

  public static function menuBack() : string
  {
    return static::menuItem('login', 'Login')
          .static::menuItem('request', 'Contribuer');
  }

  public static function menuBackGuest() : string
  {
    return static::menuItem('logout', 'Logout');
  }

  public static function menuBackAdmin() : string
  {
    return static::menuItem('posts', 'Articles')
          .static::menuItem('edit', 'Nouveau')
          .static::menuItem('comments', 'Commentaires')
          .static::menuItem('adminrequest', 'Requests')
          .static::menuItem('profile', 'Profil')
          .static::menuItem('logout', 'Logout');
  }

}
