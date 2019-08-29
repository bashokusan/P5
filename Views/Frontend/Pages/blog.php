<?php $title = "Blog"; ?>

<div class="posts_container">
  <?php foreach ($postList as $post) : ?>
    <div class="post_card">
      <h3><?= htmlentities($post->title()) ?></h3>

      <?php if (htmlentities($post->image())) : ?>
        <img src="../Public/Content/Post-<?= htmlentities($post->id()) ?>/<?= htmlentities($post->image()) ?>" alt="">
      <?php endif ?>

      <p><em>Publié le <?= htmlentities($post->publishDate()->format('d/m/Y à H\hi')) ?><?= ($post->updateDate()) ? " - Modifié le " . htmlentities($post->updateDate()->format('d/m/Y à H\hi')) : ""; ?></em></p>

      <?= (htmlentities($post->name())) ? "<p>Par ".htmlentities($post->name())."</p>" : "" ?>

      <h4><?= htmlentities($post->kicker()) ?></h4>

      <?php if (htmlentities($post->countComment())) :?>
      <p><em><?= htmlentities($post->countComment()) ?> <?= (int)$post->countComment() === 1 ? "commentaire" : "commentaires" ?></em></p>
      <?php endif ?>

      <a href="?page=article&id=<?= htmlentities($post->id()) ?>">Lire la suite</a>
    </div>
  <?php endforeach ?>
</div>

<div class="pagination">
  <?php if ($currentNbr > 1) : ?>
  <a href="?page=blog&p=<?= (int)$currentNbr - 1 ?>">Page précédente</a>
  <?php endif ?>
  <?php if ($currentNbr < $total) : ?>
  <a href="?page=blog&p=<?= (int)$currentNbr + 1 ?>">Page suivante</a>
  <?php endif ?>
</div>
