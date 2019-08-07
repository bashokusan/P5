<?php $title = "Blog | " . $response->getTitle() ?>

<div class="post_card">
  <?= $response->getTitle() ?>
  <?= $response->getPublishDate() ?><?= ($response->getUpdateDate()) ? $response->getUpdateDate() : ""; ?>
  <p>Par Auteur</p>
  <?= $response->getKicker() ?>
  <?= $response->getContent() ?>
</div>
<div class="comment_section">

  <h3>Commentaires</h3>

  <div class="comment_form">
    <form class="" action="?action=post&postid=<?= $response->getId() ?>" method="post">
      <div>
        <label for="name">Votre nom</label>
        <input type="text" name="author" id="name" value="" placeholder="votre nom">
      </div>
      <div>
        <label for="comment">Votre commentaire</label>
        <textarea name="comment" id="comment" rows="4" cols="80" placeholder="votre commentaire"></textarea>
      </div>
      <div>
        <button type="submit" name="button">Envoyer</button>
      </div>
    </form>
  </div>

<div class="comment_list">
  <?php if($comments) : ?>
    <?php foreach($comments as $comment) : ?>
      <div class="comment">
        <div class="comment_info">
          <?= $comment->getAuthor() ?>
          <?= $comment->getPublishDate() ?>
        </div>
        <div class="comment_content">
          <?= $comment->getComment() ?>
        </div>
      </div>
    <?php endforeach ?>
  <?php else : ?>
    <p>Soyez le premier à commenter.</p>
  <?php endif ?>
</div>

</div>
