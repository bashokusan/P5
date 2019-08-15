<? $title = "Accueil"; ?>

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
  </div>

</div>

<div class="contact_form">
<h2>Me contacter</h2>
<?php if($message) echo "<p class='alert success'>" . $message . "</p>"?>
  <form class="" action="" method="post">
    <div>
      <fieldset>
        <label for="name">Votre nom</label>

        <?php if(isset($errors) && in_array(Message::NAME_INVALID, $errors)) echo "<p class='alert warning'>nom invalide</p>"; ?>

        <input type="text" name="name" id="name" value="<?= $_SESSION['inputs']['name'] ? $_SESSION['inputs']['name'] : "" ?>" placeholder="exemple : John Doe">

        <?php if(isset($errors) && in_array(Message::EMAIL_INVALID, $errors)) echo "<p class='alert warning'>email invalide</p>"; ?>
        <label for="email">Votre email</label>
        <input type="email" name="email" id="email" value="<?= $_SESSION['inputs']['email'] ? $_SESSION['inputs']['email'] : "" ?>" placeholder="exemple : johndoe@mail.com">
      </fieldset>
    </div>

    <div>
      <?php if(isset($errors) && in_array(Message::MESSAGE_INVALID, $errors)) echo "<p class='alert warning'>message invalide</p>"; ?>
      <label for="message">Votre message</label>
      <textarea name="message" id="message" rows="8" cols="80" placeholder="exemple : Lorem Ipsum"><?= $_SESSION['inputs']['message'] ? $_SESSION['inputs']['message'] : "" ?></textarea>
    </div>

    <div>
      <input type="submit" name="send" value="Envoyer">
    </div>
  </form>
</div>
