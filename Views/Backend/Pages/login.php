<? $title = "Backoffice | Login"; ?>

<h2>Login</h2>
<div class="login">
  <form class="login_form" action="" method="post">
    <?php if(isset($errors) && in_array(User::EMAIL_INVALID, $errors)) echo "Email invalide"; ?>
    <input type="email" name="email" placeholder="Email" value="">

    <?php if(isset($errors) && in_array(User::PASSWORD_INVALID, $errors)) echo "Mot de passe invalide"; ?>
    <input type="password" name="password" placeholder="Mot de passe" value="">
    <input type="submit" name="login" value="Se connecter">
  </form>
</div>
<div class="request">
  <h2>Devenir administrateur</h2>
  <p>Envoyez le formulaire ci-dessous pour demander à être administrateur</p>
  <form class="login_form" action="index.html" method="post">
    <input type="email" name="email" placeholder="Email" value="">
    <textarea name="message" rows="4" cols="80" placeholder="Ecrivez un message pour vous présenter et expliquer pourquoi vous souhaitez être administrateur"></textarea>
    <input type="submit" name="request" value="Se connecter">
  </form>
  <p>Nous répondrons à votre demande dès que possible</p>
</div>
