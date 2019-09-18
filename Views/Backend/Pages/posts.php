<?php $title = "Backoffice | Articles"; ?>

<h2>Liste des articles</h2>
<?php if ($message) : ?>
  <p class='alert success'><?= htmlentities($message) ?></p>
<?php endif ?>

<div class="posts_container">
  <?php foreach ($postList as $post) : ?>
    <hr>
    <div class="post">
      <div class="post_content">
        <div class="post_card">
          <h3><?= htmlentities($post->id()) ?> | <?= htmlentities($post->title()) ?></h3>

          <p>Par <?=htmlentities($post->name())?> <em>Publié le <?= htmlentities($post->publishDate()->format('d/m/Y à H\hi')) ?><?= ($post->updateDate()) ? " - Modifié le " . htmlentities($post->updateDate()->format('d/m/Y à H\hi')) : ""; ?></em></p>

          <h4><?= $post->kicker() ?></h4>
        </div>
      </div>
      <div class="post_actions">
          <p><a href="../Public/index.php?page=article&id=<?= htmlentities($post->id()) ?>">Voir l'article</a></p>
          <p><a href="?page=edit&postid=<?= htmlentities($post->id()) ?>">Modifier</a></p>
          <form class="" action="" method="post" onsubmit="return confirm('L\'article sera supprimé définivitement. Confirmer ?')">
            <input type="hidden" name="id" value="<?= htmlentities($post->id()) ?>">
            <input type="hidden" name="t_user" value="<?= htmlentities($token) ?>">
            <input type="submit" name="delete" value="Supprimer">
          </form>
      </div>
    </div>
  <?php endforeach ?>
</div>
