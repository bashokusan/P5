<?php $title = "Backoffice | Login"; ?>

<div class="login">
  <h2>Modifier votre mot de passe</h2>

  <?php if ($error) : ?>
    <p class='alert warning'><?= htmlentities($error) ?></p>
  <?php endif ?>

  <form class="newpass_form" action="" method="post">

    <?php if (isset($errors) && in_array(User::PASSWORD_INVALID, $errors)) : ?>
      <p class='alert warning'>Email invalide</p>
    <?php endif ?>
    <input type="password" name="password" placeholder="Mot de passe" value="">

    <?php if (isset($errors) && in_array(User::PASSWORDBIS_INVALID, $errors)) : ?>
      <p class='alert warning'>Mot de passe invalide</p>
    <?php endif ?>
    <input type="password" name="passwordbis" placeholder="Confirmez le mot de passe" value="">

    <?php if (isset($_GET['restoken'])) : ?>
      <input type="hidden" name="selector" value="<?= htmlentities((string)$_GET['restoken']) ?>">
    <?php endif ?>
    <?php if (isset($_GET['validator'])) : ?>
      <input type="hidden" name="validator" value="<?= htmlentities((string)$_GET['validator']) ?>">
    <?php endif ?>
    <?php if (isset($_SESSION['t_user'])) : ?>
    <input type="hidden" name="t_user" value="<?= htmlentities((string)$_SESSION['t_user']) ?>">
    <?php endif ?>
    <input type="submit" name="updatemdp" value="Modifier">

  </form>
</div>
