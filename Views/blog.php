<?php $title = 'Blog' ?>

<div class="posts_container">
  <?php foreach($response as $post) : ?>
    <div class="post_card">
      <h2><?= $post->getTitle() ?></h2>
      <p><em><?= $post->getPublishDate() ?></em></p>
      <?= ($post->getUpdateDate()) ? "<p><em>" . $post->getUpdateDate() . "</em></p>" : ""; ?>
      <p>Auteur</p>
      <p><?= $post->getKicker() ?></p>
      <a href="?page=post&id=<?= $post->getId() ?>">Lire la suite</a>
    </div>
  <?php endforeach ?>
</div>
