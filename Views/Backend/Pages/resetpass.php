<? $title = "Backoffice | Réinitialisation du mot de passe"; ?>

<div class="reset">
  <h2>Réinitialisation du mot de passe</h2>
  <p>Vous recevrez un email contenant les insctructions à suivre pour réinitialiser votre mot de passe</p>
  <form class="reset_form" action="" method="post">
    <?php if($info) echo "<p class='alert info'>".$info."</p>"; ?>
    <?php if($warning) echo "<p class='alert warning'>".$warning."</p>"; ?>
    <input type="email" name="email" placeholder="Email" value="">

    <input type="submit" name="resetpass" value="Réinitialiser">
  </form>
</div>
