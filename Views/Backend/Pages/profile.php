<? $title = "Backoffice | Votre profil"; ?>

<h2>Votre profil</h2>
<div class="user">
  <?php if($message) echo "<p class='alert success'>" . $message . "</p>"?>

  <form class="update_form" action="" method="post">

    <label for="name">Nom</label>
    <?php if(isset($errors) && in_array(User::NAME_INVALID, $errors)) echo "<p class='alert warning'>Le nom est invalide</p>"; ?>
    <input type="text" name="name" placeholder="" value="<?= $updateuser ? $updateuser->name() : $user->name() ?>">

    <label for="email">Email</label>
    <?php if(isset($errors) && in_array(User::EMAIL_INVALID, $errors)) echo "<p class='alert warning'>Email invalide</p>"; ?>
    <input type="email" name="email" placeholder="" value="<?= $updateuser ? $updateuser->email() : $user->email() ?>">

    <input type="hidden" name="userid" value="<?= $user->id() ?>">
    <input type="submit" name="updateprofile" value="Mettre à jour">
  </form>
  <p><a href="?page=newpass">Modifier votre mot de passe</a></p>
</div>
