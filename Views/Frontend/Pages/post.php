<?php $title = 'Blog | ' . $post->title() ?>

<?php if ($message) : ?>
  <p class='alert info'><?= $message ?></p>
<?php endif ?>

<div class="post_card">
  <h2><?= $post->title() ?></h2>

  <?php if ($post->image()) : ?>
    <img src="../Public/Content/Post-<?= $post->id() ?>/<?= $post->image() ?>" alt="">
  <?php endif ?>

  <p><em>Publié le <?= $post->publishDate()->format('d/m/Y à H\hi') ?><?= ($post->updateDate()) ? " - Modifié le " . $post->updateDate()->format('d/m/Y à H\hi') : ""; ?></em></p>

  <?= ($post->name()) ? "<p>Par ".$post->name()."</p>" : "" ?>

  <h3><?= nl2br($post->kicker()) ?></h3>

  <p><?= nl2br($post->content()) ?></p>
</div>
<div class="comment_section" >

<h3>Commentaires</h3>
<div class="comment_form">
  <form class="" action="" method="post">
    <div>
      <label for="name">Votre nom</label>
      <?php if (isset($errors) && in_array(App\Models\Comment::AUTHOR_INVALID, $errors)) : ?>
        <p class='alert warning'>auteur invalide</p>
      <?php endif ?>
      <input type="text" name="author" id="name" value="<?= $_SESSION['inputs']['author'] ? htmlentities((string)$_SESSION['inputs']['author']) : "" ?>" placeholder="votre nom">
    </div>

    <div>
      <label for="content">Votre commentaire</label>
      <?php if (isset($errors) && in_array(App\Models\Comment::CONTENT_INVALID, $errors)) : ?>
        <p class='alert warning'>Commentaire invalide</p>
      <?php endif ?>
      <?php if (isset($errors) && in_array(App\Models\Comment::CONTENT_LENGHT, $errors)) : ?>
        <p class='alert warning'>Le commentaire doit faire entre 2 et 500 caractères</p>
      <?php endif ?>
      <textarea name="comment" id="content" rows="4" cols="80" placeholder="votre commentaire"><?= $_SESSION['inputs']['comment'] ? htmlentities((string)$_SESSION['inputs']['comment']) : "" ?></textarea>
    </div>

    <div>
      <input type="submit" name="add" value="Commenter">
    </div>
  </form>
</div>

<div class="comment_list">
  <?php if ($listofcomments) : ?>
    <?php foreach ($listofcomments as $comment) : ?>
      <div class="comment">
        <div class="comment_info">
          <?= $comment->author() ?>
          <?= $comment->publishDate() ?>
        </div>
        <div class="comment_content">
          <?= $comment->content() ?>
        </div>
      </div>
    <?php endforeach ?>
  <?php else : ?>
    <p>Soyez le premier à commenter.</p>
  <?php endif ?>
</div>

</div>
