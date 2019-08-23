<?php $title = "Backoffice | Login"; ?>

<div class="login">
  <h2>Login</h2>

  <form class="login_form" action="" method="post">
    <?php if ($warning) : ?>
      <p class='alert info'><?= $warning ?></p>
    <?php endif ?>
    <?php if ($prohib) : ?>
      <p class='alert warning'><?= $prohib ?></p>
    <?php endif ?>

    <?php if (isset($errors) && in_array(User::EMAIL_INVALID, $errors)) : ?>
      <p class='alert warning'>Email invalide</p>
    <?php endif ?>
    <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['inputs']['email'] ? $_SESSION['inputs']['email'] : "" ?>">

    <?php if (isset($errors) && in_array(User::PASSWORD_INVALID, $errors)) : ?>
      <p class='alert warning'>Mot de passe invalide</p>
    <?php endif ?>
    <input type="password" name="password" placeholder="Mot de passe" value="">
    <input type="submit" name="login" value="Se connecter">
  </form>
  <p><a href="?page=resetpass">Mot de passe oublié</a></p>
</div>
