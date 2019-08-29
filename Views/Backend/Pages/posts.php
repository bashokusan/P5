<?php $title = "Backoffice | Articles"; ?>

<h2>Liste des articles</h2>
<?php if ($message) : ?>
  <p class='alert success'><?= htmlentities((string)$message) ?></p>
<?php endif ?>

<div class="posts_container">
  <?php foreach ($postList as $post) : ?>
    <hr>
    <div class="post">
      <div class="post_content">
        <div class="post_card">
          <h3><?= htmlentities((string)$post->id()) ?> | <?= htmlentities((string)$post->title()) ?></h3>

          <p>Par <?=htmlentities((string)$post->name())?> <em>Publié le <?= htmlentities((string)$post->publishDate()->format('d/m/Y à H\hi')) ?><?= ($post->updateDate()) ? " - Modifié le " . htmlentities((string)$post->updateDate()->format('d/m/Y à H\hi')) : ""; ?></em></p>

          <h4><?= $post->kicker() ?></h4>
        </div>
      </div>
      <div class="post_actions">
          <p><a href="?page=edit&postid=<?= htmlentities((string)$post->id()) ?>">Modifier</a></p>
          <p><a href="?delete=<?= htmlentities((string)$post->id()) ?>&token=<?= htmlentities((string)$token) ?>">Supprimer</a></p>
          <p><a href="../Public/index.php?page=article&id=<?= htmlentities((string)$post->id()) ?>">Voir l'article</a></p>
      </div>
    </div>
  <?php endforeach ?>
</div>
