<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\PostManager;
use App\Models\CommentManager;

/**
 *
 */
class Homepage extends Controller
{
    //------------------------------------------------------------------------------
    // Home Page Methods
    //------------------------------------------------------------------------------
    /**
     * Home page
     * Main dashboard with number of posts, comments and unchecked comments list
     */
    public function homepage()
    {
        $db = DBFactory::getPDO();
        $postManager = new PostManager($db);
        $commentManager = new CommentManager($db);

        $token = $_SESSION['t_user'];
        $postsCount = $postManager->count();
        $commentCount = $commentManager->count();
        $uncheckedCount = $commentManager->count('unchecked');
        $uncheckedComment = $commentManager->getListNoId('unchecked');

        ob_start();
        require_once $this->getViewPath().'home.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }


    /**
     * Update comment for checked
     * @param  int $idcomment [description]
     * @param  int $idpost    [description]
     */
    public function updateComment($idcomment, $idpost)
    {
        $db = DBFactory::getPDO();
        $commentManager = new CommentManager($db);
        $commentManager->updateCheck($idcomment, $idpost, 1);

        header('Location: ?page=home');
    }


    /**
     * Update comment for flag
     * @param  int $idcomment [description]
     * @param  int $idpost    [description]
     */
    public function flagComment($idcomment, $idpost)
    {
        $db = DBFactory::getPDO();
        $commentManager = new CommentManager($db);
        $commentManager->updateCheck($idcomment, $idpost, 2);

        header('Location: ?page=home');
    }
}
