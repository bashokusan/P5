<? $title = "Backoffice | Devenir administrateur"; ?>

<div class="request">
  <h2>Devenir administrateur</h2>
  <?php if($message) echo "<p class='alert success'>" . $message . "</p>"?>
  <p>Envoyez le formulaire ci-dessous pour demander à être administrateur</p>

  <form class="request_form" action="" method="post">

    <?php if(isset($errors) && in_array(User::NAME_INVALID, $errors)) echo "<p class='alert warning'>Nom invalide</p>"; ?>
    <input type="name" name="name" placeholder="Nom" value="<?= $_SESSION['inputs']['name'] ? $_SESSION['inputs']['name'] : "" ?>">

    <?php if(isset($errors) && in_array(User::EMAIL_INVALID, $errors)) echo "<p class='alert warning'>Email invalide</p>"; ?>
    <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['inputs']['email'] ? $_SESSION['inputs']['email'] : "" ?>">

    <?php if(isset($errors) && in_array(User::MESSAGE_INVALID, $errors)) echo "<p class='alert warning'>Message invalide</p>"; ?>
    <textarea name="message" rows="4" cols="80" placeholder="Ecrivez un message pour vous présenter et expliquer pourquoi vous souhaitez être administrateur"><?= $_SESSION['inputs']['message'] ? $_SESSION['inputs']['message'] : "" ?></textarea>

    <input type="submit" name="request" value="Envoyer la demande">

  </form>
  <p>Nous répondrons à votre demande dès que possible</p>
</div>
