<? $title = "Backoffice | Login"; ?>

<div class="login">
  <h2>Modifier votre mot de passe</h2>
  <form class="login_form" action="" method="post">
    <?php if(isset($errors) && in_array(User::PASSWORD_INVALID, $errors)) echo "<p class='alert warning'>Email invalide</p>"; ?>
    <input type="password" name="password" placeholder="Mot de passe" value="">

    <?php if(isset($errors) && in_array(User::PASSWORDBIS_INVALID, $errors)) echo "<p class='alert warning'>Mot de passe invalide</p>"; ?>
    <input type="password" name="passwordbis" placeholder="Confirmez le mot de passe" value="">

    <input type="submit" name="updatemdp" value="Modifier">
  </form>
</div>
