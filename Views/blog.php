<?php foreach($response as $post) : ?>
  <h2><?= $post->getTitle() ?></h2>
  <em><?= $post->getPublishDate() ?></em><em>, modifié le <?= $post->getUpdateDate() ?></em>
  <p>Auteur</p>
  <p><?= $post->getKicker() ?></p>
  <a href="?page=post&id=<?= $post->getId() ?>">Lire la suite</a>
<?php endforeach ?>
