<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?? $title = 'Mon site' ?></title>
    <meta name="description" content="">

    <link rel="stylesheet" href="../Public/css/stylesheet.min.css">
    <link rel="shortcut icon" type="image/jpg" href="../content/favicon.png">
  </head>

  <body>

    <header>
      <div class="logo">
        <a href="index.php"><img src="../content/logo_white.png" alt="logo"></a>
      </div>
      <nav>
        <ul>
          <div class="nav_menu">
            <?= $menu ?>
          </div>
          <div class="nav_cta">
            <li><a href="#">Contactez moi !</a></li>
          </div>
        </ul>
      </nav>
    </header>

    <div class="container">
      <?= $content ?>
    </div>

    <?php require_once "footer.php" ?>
  </body>
</html>
