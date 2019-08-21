<?php $title = "Blog"; ?>

<div class="posts_container">
  <?php foreach($postList as $post) : ?>
    <div class="post_card">
      <h3><?= $post->id() ?> | <?= $post->title() ?></h3>

      <?php if($post->image()) : ?>
        <img src="../Public/Content/Post-<?= $post->id() ?>/<?= $post->image() ?>" alt="">
      <?php endif ?>

      <p><em>Publié le <?= $post->publishDate()->format('d/m/Y à H\hi') ?><?= ($post->updateDate()) ? " - Modifié le " . $post->updateDate()->format('d/m/Y à H\hi') : ""; ?></em></p>

      <?= ($post->name()) ? "<p>Par ".$post->name()."</p>" : "" ?>

      <h4><?= $post->kicker() ?></h4>

      <?php if($post->countComment()) :?>
      <p><em><?= $post->countComment() ?> <?= $post->countComment() == 1 ? "commentaire" : "commentaires" ?></em></p>
      <?php endif ?>

      <a href="?page=article&id=<?= $post->id() ?>">Lire la suite</a>
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
