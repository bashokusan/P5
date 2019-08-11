<?php $title = "Blog | " .  $post->getTitle() ?>

<div class="post_card">
  <h2><?= $post->getTitle() ?></h2>
  <p><em>Publié le <?= $post->getPublishDate() ?><?= ($post->getUpdateDate()) ? " - Modifié le " . $post->getUpdateDate() : ""; ?></em></p>
  <p>Par <?= $post->getAuthor() ?></p>
  <h3><?= $post->getKicker() ?></h3>
  <p><?= $post->getContent() ?></p>
</div>
<div class="comment_section">

  <h3>Commentaires</h3>
  <div class="comment_form">
    <? $error; ?>
    <form class="" action="?page=post&id=<?= $post->getId() ?>&action=comment" method="post">
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
    <p><?= $post->getCountComment() == 1 ? $post->getCountComment() . " commentaire" : $post->getCountComment() . " commentaires" ?></p>
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
