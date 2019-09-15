<?php

namespace App\Controllers\Helpers;

/**
 * Class for random but useful functions.
 */
class Menu
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
        if (isset($_GET['page']) &&  $_GET['page'] === $page) {
            $class = "class='active'";
        };
        return "<li><a href='?page=".$page."'".$class.">".$name."</a></li>";
    }

    /**
     * @return string Return all the <li> for the menu
     */
    public function menuFront() : string
    {
        return $this->menuItem('blog', 'Blog');
    }

    /**
     * @return string Return all the <li> for the menu
     */
    public function menuBack() : string
    {
        return $this->menuItem('login', 'Login')
          .$this->menuItem('request', 'Contribuer');
    }

    /**
     * @return string Return all the <li> for the menu
     */
    public function menuBackGuest() : string
    {
        return $this->menuItem('logout', 'Logout');
    }

    /**
     * @return string Return all the <li> for the menu
     */
    public function menuBackAdmin() : string
    {
        return $this->menuItem('posts', 'Articles')
          .$this->menuItem('edit', 'Nouveau')
          .$this->menuItem('comments', 'Commentaires')
          .$this->menuItem('adminrequest', 'Requests')
          .$this->menuItem('profile', 'Profil')
          .$this->menuItem('logout', 'Logout');
    }
}
