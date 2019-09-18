<?php

namespace App\Controllers\Backend;

use App\Models\CommentManager;

/**
 *
 */
class CommentsPage extends BackendController
{
    //------------------------------------------------------------------------------
    // Comments Page Methods
    //------------------------------------------------------------------------------
    /**
     * Comments page
     * Displays all comments ordered by posts
     */
    public function commentsPage()
    {
        $commentManager = new CommentManager($this->getDb());
        $commentsList = $commentManager->getListNoId();

        ob_start();
        require_once $this->getViewPath().'comments.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }
}
