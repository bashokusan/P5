<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\PostManager;

/**
 *
 */
class PostsList extends Controller
{

  //------------------------------------------------------------------------------
    // Posts Page Methods
    //------------------------------------------------------------------------------
    /**
     * Posts page
     * Displays all posts
     */
    public function postsPage()
    {
        $db = DBFactory::getPDO();
        $postManager = new PostManager($db);

        $token = $_SESSION['t_user'];
        $postList = $postManager->getList();

        ob_start();
        require_once $this->getViewPath().'posts.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }


    /**
     * Deletion of post and its comments
     * @param  int $id Post id
     */
    public function deletePost($id)
    {
        $db = DBFactory::getPDO();
        $postManager = new PostManager($db);
        $postManager->delete($id);

        header('Location: ?page=posts');
    }
}
