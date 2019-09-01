<?php

namespace App\Controllers\Backend;

use App\Models\DBFactory;
use App\Models\PostManager;

/**
 *
 */
class PostsList extends BackendController
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

        if (isset($_POST['delete'])) {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $this->deletePost((int)$_POST['id']);
            }
        }

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
