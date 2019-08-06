<?php $title = 'Blog' ?>

<div class="posts_container">
  <?php foreach($response as $post) : ?>
    <div class="post_card">
      <?= $post->getTitle() ?>
      <?= $post->getPublishDate() ?><?= ($post->getUpdateDate()) ? $post->getUpdateDate() : ""; ?>
      <p>Par Auteur</p>
      <?= $post->getKicker() ?>
      <a href="?page=post&id=<?= $post->getId() ?>">Lire la suite</a>
    </div>
  <?php endforeach ?>
</div>
