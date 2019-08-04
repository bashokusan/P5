<?php
// Composer autoload
require 'vendor/autoload.php';

// Whoops, to be deleted when live
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$db = new PDO("mysql:host=127.0.0.1; dbname=miniblog", "root", "root");
$query = $db->prepare("SELECT * FROM articles WHERE id = :id");
$query->execute([
  'id' => $_GET['id']
]);
$response = $query->fetch();

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Titre du post</title>
  </head>
  <body>

    <header>
      <h1>Mon blog</h1>
      <nav>
        <ul>
          <li><a href="blog.php">Blog</a></li>
        </ul>
      </nav>
    </header>

    <h2><?= $response['title'] ?></h2>
    <em><?= $response['publish_date'] ?></em><em>, modifié le <?= $response['update_date'] ?></em>
    <p>Auteur</p>
    <p><?= $response['kicker'] ?></p>
    <p><?= $response['content'] ?></p>

    </body>
</html>
