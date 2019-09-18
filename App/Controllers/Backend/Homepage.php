<?php

namespace App\Controllers\Backend;

use App\Models\PostManager;
use App\Models\CommentManager;

/**
 *
 */
class Homepage extends BackendController
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
        $postManager = new PostManager($this->getDb());
        $commentManager = new CommentManager($this->getDb());

        $token = $_SESSION['t_user'];
        $postsCount = $postManager->count();
        $commentCount = $commentManager->count();
        $uncheckedCount = $commentManager->count('unchecked');
        $uncheckedComment = $commentManager->getListNoId('unchecked');

        if (isset($_POST['check'])) {
            if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['post']) && !empty($_POST['post'])) {
                $this->updateComment((int)$_POST['id'], (int)$_POST['post']);
            }
        } elseif (isset($_POST['flag'])) {
            if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['post']) && !empty($_POST['post'])) {
                $this->flagComment((int)$_POST['id'], (int)$_POST['post']);
            }
        }

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
        $commentManager = new CommentManager($this->getDb());
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
        $commentManager = new CommentManager($this->getDb());
        $commentManager->updateCheck($idcomment, $idpost, 2);

        header('Location: ?page=home');
    }
}
