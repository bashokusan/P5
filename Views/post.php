<?php $title = "Blog | " . $response->getTitle() ?>

<div class="post_card">
  <h2><?= $response->getTitle() ?></h2>
  <p><em><?= $response->getPublishDate() ?></em></p>
  <?= ($response->getUpdateDate()) ? "<p><em>" . $response->getUpdateDate() . "</em></p>" : ""; ?>
  <p>Auteur</p>
  <p><?= $response->getKicker() ?></p>
  <p><?= $response->getContent() ?></p>
</div>
<div class="comment_section">

  <h3>Commentaires</h3>

  <div class="comment_form">
    <form class="" action="?action=post&postid=<?= $response->getId() ?>" method="post">
      <p><input type="text" name="author" value="" placeholder="votre nom"></p>
      <p><textarea name="comment" rows="4" cols="80" placeholder="votre commentaire"></textarea></p>
      <p><button type="submit" name="button">Envoyer</button></p>
    </form>
  </div>

<div class="comment_list">
  <?php if($comments) : ?>
    <?php foreach($comments as $comment) : ?>
      <div class="comment">
        <p><?= $comment->getAuthor() ?></p>
        <p><em><?= $comment->getPublishDate() ?></em></p>
        <p><?= $comment->getComment() ?></p>
      </div>
    <?php endforeach ?>
  <?php else : ?>
    <p>Soyez le premier à commenter.</p>
  <?php endif ?>
</div>

</div>
