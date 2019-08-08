<?php $title = "Mon site" ?>

<div class="main_info">

  <h1>Bienvenue sur mon super site</h1>

  <div class="about">
    <h2>A propos de moi</h2>
    <p>Pierre Simonnet</p>
    <p>Je suis web développeur</p>
    <span><i class="fas fa-file-download"></i></span> <a href="../Content/PierreSimonnet_CV.pdf">Téléchargez mon CV</a>
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

<div class="contact_form">
  <h2>Me contacter</h2>

  <form class="" action="?action=contact" method="post">
    <div>
      <fieldset>
        <label for="name">Votre nom</label>
        <input type="text" name="name" id="name" value="" placeholder="exemple : John Doe">
        <label for="email">Votre email</label>
        <input type="email" name="email" id="email" value="" placeholder="exemple : johndoe@mail.com">
      </fieldset>
    </div>
    <div>
      <label for="message">Votre message</label>
      <textarea name="message" id="message" rows="8" cols="80" placeholder="exemple : Lorem Ipsum"></textarea>
    </div>
    <div><button type="submit" name="button">Envoyer</button></div>
  </form>
</div>
