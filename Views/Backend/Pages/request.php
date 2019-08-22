<? $title = "Backoffice | Contribuer"; ?>

<div class="request">
  <h2>Contribuer au site</h2>
  <?php if($message) : ?>
    <p class='alert success'><?= $message ?></p>
  <?php endif ?>
  <p>Envoyez le formulaire ci-dessous pour demander à être administrateur</p>

  <form class="request_form" action="" method="post">

    <?php if(isset($errors) && in_array(User::NAME_INVALID, $errors)) : ?>
      <p class='alert warning'>Nom invalide</p>
    <?php endif ?>
    <input type="name" name="name" placeholder="Nom" value="<?= $_SESSION['inputs']['name'] ? $_SESSION['inputs']['name'] : "" ?>">

    <?php if(isset($errors) && in_array(User::EMAIL_INVALID, $errors)) : ?>
      <p class='alert warning'>Email invalide</p>
    <?php endif ?>
    <input type="email" name="email" placeholder="Email" value="<?= $_SESSION['inputs']['email'] ? $_SESSION['inputs']['email'] : "" ?>">

    <?php if(isset($errors) && in_array(User::MESSAGE_INVALID, $errors)) : ?>
      <p class='alert warning'>Message invalide</p>
    <?php endif ?>
    <?php if(isset($errors) && in_array(User::CONTENT_LENGHT, $errors)) : ?>
      <p class='alert warning'>Le message doit faire entre 10 et 500 caractères</p>
    <?php endif ?>
    <textarea name="message" rows="4" cols="80" placeholder="Ecrivez un message pour vous présenter et expliquer pourquoi vous souhaitez être administrateur"><?= $_SESSION['inputs']['message'] ? $_SESSION['inputs']['message'] : "" ?></textarea>

    <input type="submit" name="request" value="Envoyer la demande">

  </form>
  <p>Nous répondrons à votre demande dès que possible</p>
</div>
