<header>
  <div class="logo">
    <a href="index.php"><img src=<?= $title !== "Accueil" ? "../Public/Content/logo_white.png" : "../Public/Content/logo_aqua.png" ?> alt="logo"></a>
  </div>
  <nav>
    <ul>
      <div class="nav_menu">
        <?= $menu ?>
      </div>
      <div class="nav_cta">
        <li><a href="../Backoffice/index.php">Administration</a></li>
      </div>
    </ul>
  </nav>
</header>
