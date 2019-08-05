<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?? 'Mon site' ?></title>
    <meta name="description" content="">

    <link rel="stylesheet" href="../Public/css/stylesheet.min.css">
    <link rel="shortcut icon" type="image/jpg" href="../content/favicon.png">
  </head>

  <body>

    <header>
      <a href="index.php"><img src="../content/favicon.png" alt="logo"></a>
      <nav>
        <ul>
          <li><a href="?page=home">About</a></li>
          <li><a href="?page=blog">Blog</a></li>
          <li><a href="#">Contactez moi !</a></li>
        </ul>
      </nav>
    </header>

    <?= $content ?>

    <?php require_once "footer.php" ?>
  </body>
</html>
