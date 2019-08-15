<? $title = "Backoffice | Requests"; ?>

<h2>Demande de contribution : </h2>

<div class="userList">
  <?php if($userList) : ?>
    <h3>Demande en attente :</h3>
    <?php foreach($userList as $user) : ?>
      <div class="user">
        <p>Date de la demande : <?= $user->requestDate() ?></p>
        <p>Nom : <?= $user->name() ?></p>
        <p>Email : <?= $user->email() ?></p>
        <p>Message :</p>
        <p><?= $user->message() ?></p>
      </div>
      <a href="?acceptrequest=<?= $user->id() ?>">Accepter</a>
    <?php endforeach ?>
  <?php endif ?>
</div>

<div class="userList">
  <?php if($acceptedUserList) : ?>
    <h3>Demande acceptée :</h3>
    <?php foreach($acceptedUserList as $acceptedUser) : ?>
      <div class="user">
        <p>Nom : <?= $acceptedUser->name() ?></p>
        <p>Email : <?= $acceptedUser->email() ?></p>
        <p>Message :</p>
        <p><?= $acceptedUser->message() ?></p>
        <p><strong><?= $acceptedUser->confirm() == 0 ? "L'utilisateur n'a pas encore confirmé" : "Administrateur confirmé" ?></strong></p>
        <hr>
      </div>
    <?php endforeach ?>
  <?php endif ?>
</div>