<?php

namespace App\Controllers\Backend;

/**
 *
 */
class Logout
{
  //------------------------------------------------------------------------------
  // Log Out Page Methods
  //------------------------------------------------------------------------------
  /**
   * Destroy session when logout
   */
  public function logout()
  {
      $_SESSION = [];
      session_destroy();
      header('Location: ?page=login');
  }
}
