<? $title = "Backoffice | Articles"; ?>

<h2>Liste des articles</h2>
<div class="posts_container">
  <?php foreach($postList as $post) : ?>
    <hr>
    <div class="post">
      <div class="post_card">
        <h3><?= $post->id() ?> | <?= $post->title() ?></h3>

        <p>Par <?=$post->author()?> <em>Publié le <?= $post->publishDate() ?><?= ($post->updateDate()) ? " - Modifié le " . $post->updateDate() : ""; ?></em></p>

        <h4><?= $post->kicker() ?></h4>

        <?php if($post->countComment()) :?>
        <p><em><?= $post->countComment() ?> <?= $post->countComment() == 1 ? "commentaire" : "commentaires" ?></em></p>
        <?php endif ?>
      </div>
      <div class="post_actions">
          <p>Modifier</p>
          <p>Supprimer</p>
      </div>
    </div>
  <?php endforeach ?>
</div>
