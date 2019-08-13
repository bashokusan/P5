<? $title = "Backoffice | Requests"; ?>

<h2>Demande de contribution : </h2>

<div class="userList">
  <?php if($userList) : ?>
    <h3>Demande en attente :</h3>
    <?php foreach($userList as $user) : ?>
      <div class="user">
        <p><?= $user->requestDate() ?></p>
        <p><?= $user->name() ?></p>
        <p><?= $user->email() ?></p>
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
        <p><?= $acceptedUser->name() ?></p>
        <p><?= $acceptedUser->email() ?></p>
        <p><?= $acceptedUser->message() ?></p>
      </div>
    <?php endforeach ?>
  <?php endif ?>
</div>
