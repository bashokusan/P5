<?php

namespace App\Controllers\Backend;

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
        $postManager = new PostManager($this->getDb());

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
        $postManager = new PostManager($this->getDb());
        $postManager->delete($id);

        header('Location: ?page=posts');
    }
}
