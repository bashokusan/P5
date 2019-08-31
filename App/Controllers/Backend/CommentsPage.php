<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\CommentManager;

/**
 *
 */
class CommentsPage extends Controller
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
        $db = DBFactory::getPDO();
        $commentManager = new CommentManager($db);
        $commentsList = $commentManager->getListNoId();

        ob_start();
        require_once $this->getViewPath().'comments.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }
}
