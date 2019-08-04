<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
  </head>
  <link rel="stylesheet" href="../Public/css/stylesheet.min.css">
  <body>

    <header>
      <h1>Mon site</h1>
      <nav>
        <ul>
          <li><a href="?page=home">Home</a></li>
          <li><a href="?page=blog">Blog</a></li>
        </ul>
      </nav>
    </header>

    <?= $content ?>

    <?php require_once "footer.php" ?>
  </body>
</html>
