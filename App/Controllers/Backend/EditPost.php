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
        $_SESSION['inputs'] = [];

        if (isset($_GET['postid']) && !empty($_GET['postid'])) {
            $id = (int)$_GET['postid'];
            $post = $postManager->getUnique($id);
        }

        if (isset($_POST['idauthor'])) {
            $_SESSION['inputs'] = $_POST;

            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                if ($_FILES['image']['error'] === 0) {
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    $infosfichier = pathinfo($_FILES['image']['name']);
                    $extension_upload = strtolower($infosfichier['extension']);
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= 2000000) {
                            $fileName = uniqid(). "." .$extension_upload;
                        } else {
                            $imgerrors = "Le fichier doit faire moins de 2mo";
                        }
                    } else {
                        $imgerrors = "Le fichier n'est pas au bon format";
                    }
                } else {
                    $imgerrors = "Le fichier est invalide";
                }
            } elseif (isset($_POST['currentimg']) && !empty($_POST['currentimg'])) {
                $fileName = htmlentities($_POST['currentimg']);
            } else {
                $fileName = null;
            }

            $title = htmlspecialchars($_POST['title']);
            $kicker = htmlspecialchars($_POST['kicker']);
            $content = htmlspecialchars($_POST['content']);

            $data = [
      'idauthor' => (int)$_POST['idauthor'],
      'title' => $title,
      'kicker' => $kicker,
      'content' => $content
    ];

            if (isset($fileName)) {
                $data['image'] = $fileName;
            }

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

                if (isset($fileName)) {
                    $path = '../Public/Content/post-'.$id;
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    move_uploaded_file($_FILES['image']['tmp_name'], $path . DIRECTORY_SEPARATOR . $fileName);

                    $postManager->uploadImg($fileName, (int)$id);
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
