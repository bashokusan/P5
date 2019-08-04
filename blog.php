<?php
// Composer autoload
require 'vendor/autoload.php';

// Whoops, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$db = new PDO("mysql:host=127.0.0.1; dbname=miniblog", "root", "root");
$data = $db->query("SELECT * FROM articles");
$response = $data->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
  </head>
  <body>

    <header>
      <h1>Mon blog</h1>
      <nav>
        <ul>
          <li><a href="index.php">Accueil</a></li>
        </ul>
      </nav>
    </header>

    <?php foreach($response as $post) : ?>
    <h2><?= $post['title'] ?></h2>
    <em><?= $post['publish_date'] ?></em><em>, modifié le <?= $post['update_date'] ?></em>
    <p>Auteur</p>
    <p><?= $post['kicker'] ?></p>
    <a href="post.php?id=<?= $post['id'] ?>">Lire la suite</a>
    <?php endforeach ?>

    </body>
</html>
