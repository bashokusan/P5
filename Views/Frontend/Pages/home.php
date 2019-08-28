<?php $title = "Accueil"; ?>

<div class="top">

  <div class="main_info">

    <h1>Bienvenue sur mon super site</h1>

    <div class="about">
      <h2>A propos de moi</h2>
      <p>Pierre Simonnet</p>
      <p>Je suis web développeur</p>
      <span><i class="fas fa-file-download"></i></span> <a href="../Public/Content/PierreSimonnet_CV.pdf">Téléchargez mon CV</a>
    </div>

    <div class="sns">
      <h3>Mes réseaux :</h3>
      <ul class="social">
        <li><a href="https://github.com/bashokusan"><i class="fab fa-github fa-2x" aria-hidden=true></i></a></li>
        <li><a href="https://www.linkedin.com/in/simonnetpierre"><i class="fab fa-linkedin-in fa-2x" aria-hidden=true></i></a></li>
        <li><a href="https://www.instagram.com/pierre_bashoku/"><i class="fab fa-instagram fa-2x" aria-hidden=true></i></a></li>
      </ul>
    </div>

  </div>

  <div class="hero">
    <img src="../Public/Content/042915114454.jpg" alt="hero image">
  </div>

</div>

<div class="contact_form">
<h2>Me contacter</h2>
  <?php if ($message) : ?>
    <p class='alert info'><?= $message ?></p>
  <?php endif ?>
  <form class="" action="" method="post">
    <div>
      <fieldset>
        <label for="name">Votre nom</label>
        <?php if (isset($errors) && in_array(App\Models\Message::NAME_INVALID, $errors)) : ?>
          <p class='alert warning'>nom invalide</p>
        <?php endif ?>
        <input type="text" name="name" id="name" value="<?= $_SESSION['inputs']['name'] ? $_SESSION['inputs']['name'] : "" ?>" placeholder="exemple : John Doe">

        <label for="email">Votre email</label>
        <?php if (isset($errors) && in_array(App\Models\Message::EMAIL_INVALID, $errors)) : ?>
          <p class='alert warning'>email invalide</p>
        <?php endif ?>
        <input type="email" name="email" id="email" value="<?= $_SESSION['inputs']['email'] ? $_SESSION['inputs']['email'] : "" ?>" placeholder="exemple : johndoe@mail.com">
      </fieldset>
    </div>

    <div>
      <label for="message">Votre message</label>
      <?php if (isset($errors) && in_array(App\Models\Message::MESSAGE_INVALID, $errors)) : ?>
        <p class='alert warning'>message invalide</p>
      <?php endif ?>
      <?php if (isset($errors) && in_array(App\Models\Message::MESSAGE_LENGHT, $errors)) : ?>
        <p class='alert warning'>Le message doit faire entre 10 et 500 caractères</p>
      <?php endif ?>
      <textarea name="message" id="message" rows="8" cols="80"><?= $_SESSION['inputs']['message'] ? $_SESSION['inputs']['message'] : "" ?></textarea>
    </div>

    <div>
      <input type="submit" name="send" value="Envoyer">
    </div>
  </form>
</div>
