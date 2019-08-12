<?php $title = 'Blog | ' . $post->title() ?>

<div class="post_card">
  <h2><?= $post->title() ?></h2>

  <p><em>Publié le <?= $post->publishDate() ?><?= ($post->updateDate()) ? " - Modifié le " . $post->updateDate() : ""; ?></em></p>

  <p>Par <?= $post->author() ?></p>

  <h3><?= $post->kicker() ?></h3>

  <p><?= $post->content() ?></p>
</div>
<div class="comment_section">

<h3>Commentaires</h3>
<div class="comment_form">
  <form class="" action="" method="post">
    <div>
      <?php if(isset($errors) && in_array(Comment::AUTHOR_INVALID, $errors)) echo "<p class='alert warning'>auteur invalide</p>"; ?>
      <label for="name">Votre nom</label>
      <input type="text" name="author" id="name" value="" placeholder="votre nom">
    </div>

    <div>
      <?php if(isset($errors) && in_array(Comment::CONTENT_INVALID, $errors)) echo "<p class='alert warning'>commentaire invalide</p>"; ?>
      <label for="content">Votre commentaire</label>
      <textarea name="content" id="content" rows="4" cols="80" placeholder="votre commentaire"></textarea>
    </div>

    <div>
      <input type="submit" name="add" value="Commenter">
    </div>
  </form>
</div>

<div class="comment_list">
  <?php if($listofcomments) : ?>
    <?php foreach($listofcomments as $comment) : ?>
      <div class="comment">
        <div class="comment_info">
          <?= $comment->author() ?>
          <?= $comment->publishDate() ?>
        </div>
        <div class="comment_content">
          <?= $comment->content() ?>
        </div>
        <div class="action">
          <a href="?update=<?= $comment->id() ?>">Modifier</a> / <a href="delete=<?= $comment->id() ?>">Supprimer</a>
        </div>
      </div>
    <?php endforeach ?>
  <?php else : ?>
    <p>Soyez le premier à commenter.</p>
  <?php endif ?>
</div>

</div>
