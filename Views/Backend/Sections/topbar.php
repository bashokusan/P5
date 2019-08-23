<header>
  <div class="logo">
    <a href="index.php"><img src=<?= $title == "Backoffice | Accueil" ? "../Backoffice/Content/logo_yellow.png" : "../Backoffice/Content/logo_white.png" ?> alt="logo"></a>
  </div>
  <nav>
    <ul>
      <div class="nav_menu">
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") : ?>
          <?= App\Models\Menu::menuBackAdmin()  ?>
        <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] == "guest") :?>
          <?= App\Models\Menu::menuBackGuest()  ?>
        <?php else : ?>
          <?= App\Models\Menu::menuBack()  ?>
        <?php endif ?>
      </div>
      <div class="nav_cta">
        <li><a href="../Public/index.php">Voir le site</a></li>
      </div>
    </ul>
  </nav>
</header>
