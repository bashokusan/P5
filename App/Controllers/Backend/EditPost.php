<?php

namespace App\Controllers\Backend;

use App\Controllers\Controller;

use App\Models\DBFactory;
use App\Models\Post;
use App\Models\PostManager;
use App\Models\UserManager;

/**
 *
 */
class EditPost extends Controller
{

  //------------------------------------------------------------------------------
    // Edit Page Methods
    //------------------------------------------------------------------------------
    /**
     * Edit page
     * Update or create new post
     */
    public function editPage()
    {
        $db = DBFactory::getPDO();
        $postManager = new PostManager($db);
        $userManager = new UserManager($db);
        $users = $userManager->getList('confirmed');
        $sessionid = (int)$_SESSION['id'];
        $loggedinUser = $userManager->getUser($sessionid);

        $token = $_SESSION['t_user'];

        if (isset($_GET['postid']) && !empty($_GET['postid'])) {
            $id = (int)$_GET['postid'];
            $post = $postManager->getUnique($id);
        }

        if (isset($_POST['idauthor'])) {
            $title = htmlspecialchars((string)$_POST['title']);
            $kicker = htmlspecialchars((string)$_POST['kicker']);
            $content = htmlspecialchars((string)$_POST['content']);

            $data = [
      'idauthor' => (int)$_POST['idauthor'],
      'title' => $title,
      'kicker' => $kicker,
      'content' => $content
    ];


            $newPost = new Post($data);

            if (isset($_POST['id']) && isset($_GET['postid']) && !empty($_GET['postid'])) {
                $id = (int)$_POST['id'];
                $newPost->setId($id);
            }

            if ($newPost->isValid() && empty($imgerrors)) {
                $postManager->save($newPost);

                if ($newPost->id()) {
                    $id = $newPost->id();
                } else {
                    $id = $db->lastInsertId();
                }


                header('Location: ?page=posts');
            } else {
                $errors = $newPost->errors();
            }
        }

        ob_start();
        require_once $this->getViewPath().'edit.php';
        $content = ob_get_clean();
        require_once $this->getTemplatePath();
    }
}
