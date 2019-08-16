<? $title = "Backoffice | Votre profil"; ?>

<h2>Votre profil</h2>
<div class="user">
  <p>Nom : <?= $user->name() ?></p>
  <p>Email : <?= $user->email() ?></p>
  <a href="?page=newpass">Modifier votre mot de passe</a>
</div>
