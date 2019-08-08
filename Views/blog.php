<div class="posts_container">
  <?php foreach($response as $post) : ?>
    <div class="post_card">
      <h2><?= $post->getTitle() ?></h2>
      <p><em>Publié le <?= $post->getPublishDate() ?><?= ($post->getUpdateDate()) ? " - Modifié le " . $post->getUpdateDate() : ""; ?></em></p>
      <p>Par Auteur</p>
      <h3><?= $post->getKicker() ?></h3>
      <a href="?page=post&id=<?= $post->getId() ?>">Lire la suite</a>
    </div>
  <?php endforeach ?>
</div>
