<? $title = "Backoffice | Login"; ?>

<div class="login">
  <h2>Login</h2>
  <?php if($prohib) echo "<p class='alert warning'>".$prohib."</p>"; ?>
  <form class="login_form" action="" method="post">
    <?php if(isset($errors) && in_array(User::EMAIL_INVALID, $errors)) echo "<p class='alert warning'>Email invalide</p>"; ?>
    <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['inputs']['email'] ? $_SESSION['inputs']['email'] : "" ?>">

    <?php if(isset($errors) && in_array(User::PASSWORD_INVALID, $errors)) echo "<p class='alert warning'>Mot de passe invalide</p>"; ?>
    <input type="password" name="password" placeholder="Mot de passe" value="">
    <input type="submit" name="login" value="Se connecter">
  </form>
  <p><a href="?page=request">Devenir administrateur</a></p>
</div>
