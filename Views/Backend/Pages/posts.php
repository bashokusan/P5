<? $title = "Backoffice | Articles"; ?>

<h2>Liste des articles</h2>
<div class="posts_container">
  <?php foreach($postList as $post) : ?>
    <div class="post_card">
      <h3><?= $post->id() ?> | <?= $post->title() ?></h3>

      <p><em>Publié le <?= $post->publishDate() ?><?= ($post->updateDate()) ? " - Modifié le " . $post->updateDate() : ""; ?></em></p>

      <?= ($post->author()) ? "<p>Par ".$post->author()."</p>" : "" ?>

      <h4><?= $post->kicker() ?></h4>

      <?php if($post->countComment()) :?>
      <p><em><?= $post->countComment() ?> <?= $post->countComment() == 1 ? "commentaire" : "commentaires" ?></em></p>
      <?php endif ?>

      <a href="?page=article&id=<?= $post->id() ?>">Lire la suite</a>
    </div>
  <?php endforeach ?>
</div>
