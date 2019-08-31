<?php $title = "Blog"; ?>

<div class="posts_container">
  <?php foreach ($postList as $post) : ?>
    <div class="post_card">
      <h3><?= htmlentities($post->title()) ?></h3>

      <p><em>Publié le <?= htmlentities($post->publishDate()->format('d/m/Y')) ?><?= ($post->updateDate()) ? " - Modifié le " . htmlentities($post->updateDate()->format('d/m/Y')) : ""; ?></em></p>

      <?= (htmlentities($post->name())) ? "<p>Par ".htmlentities($post->name())."</p>" : "" ?>

      <h4><?= htmlentities($post->kicker()) ?></h4>

      <?php if (htmlentities($post->countComment())) :?>
      <p><em><?= htmlentities($post->countComment()) ?> <?= (int)$post->countComment() === 1 ? "commentaire" : "commentaires" ?></em></p>
      <?php endif ?>

      <a href="?page=article&id=<?= htmlentities($post->id()) ?>">Lire la suite</a>
    </div>
  <?php endforeach ?>
</div>
