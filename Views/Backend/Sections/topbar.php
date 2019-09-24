<header>
  <div class="logo">
    <a href="index.php"><img src=<?= $title == "Backoffice | Accueil" ? "../Backoffice/Content/logo_yellow.png" : "../Backoffice/Content/logo_white.png" ?> alt="logo"></a>
    <i class='fa fa-bars fa-2x' aria-hidden='true' style='color:white'></i>
  </div>
  <nav class="menu">
    <ul>
      <div class="nav_menu">
        <?= $menu ?>
      </div>
      <div class="nav_cta">
        <li><a href="../Public/index.php">Voir le site</a></li>
      </div>
    </ul>
  </nav>
</header>
