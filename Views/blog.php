<div class="posts_container">
  <?php foreach($response as $post) : ?>
    <div class="post_card">
      <h2><?= $post->getTitle() ?></h2>
      <p><em>Publié le <?= $post->getPublishDate() ?><?= ($post->getUpdateDate()) ? " - Modifié le " . $post->getUpdateDate() : ""; ?></em></p>
      <p>Par Auteur</p>
      <h3><?= $post->getKicker() ?></h3>
      <a href="?page=post&id=<?= $post->getId() ?>">Lire la suite</a><span><?= $post->getId() ?></span>
    </div>
  <?php endforeach ?>
</div>

<div class="pagination">
  <?php if($currentNbr > 1) : ?>
  <a href="?page=blog&p=<?= $currentNbr - 1 ?>">Page précédente</a>
  <?php endif ?>
  <?php if($currentNbr < $total) : ?>
  <a href="?page=blog&p=<?= $currentNbr + 1 ?>">Page suivante</a>
  <?php endif ?>
</div>
