<?php $title = 'Blog | ' . htmlentities($post->title()) ?>

<?php if ($message) : ?>
  <p class='alert info'><?= htmlentities($message) ?></p>
<?php endif ?>

<div class="post_card">
  <h2><?= htmlentities($post->title()) ?></h2>

  <p><em>Publié le <?= htmlentities($post->publishDate()->format('d/m/Y à H\hi')) ?><?= ($post->updateDate()) ? " - Modifié le " . htmlentities($post->updateDate()->format('d/m/Y à H\hi')) : ""; ?></em></p>

  <?= ($post->name()) ? "<p>Par ".htmlentities($post->name())."</p>" : "" ?>

  <h3><?= nl2br(htmlentities($post->kicker())) ?></h3>

  <p><?= nl2br(htmlentities($post->content())) ?></p>
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
      <input type="text" name="author" id="name" value="" placeholder="votre nom">
    </div>

    <div>
      <label for="content">Votre commentaire</label>
      <?php if (isset($errors) && in_array(App\Models\Comment::CONTENT_INVALID, $errors)) : ?>
        <p class='alert warning'>Commentaire invalide</p>
      <?php endif ?>
      <?php if (isset($errors) && in_array(App\Models\Comment::CONTENT_LENGHT, $errors)) : ?>
        <p class='alert warning'>Le commentaire doit faire entre 2 et 500 caractères</p>
      <?php endif ?>
      <textarea name="comment" id="content" rows="4" cols="80" placeholder="votre commentaire"></textarea>
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
          <?= htmlentities($comment->author()) ?>
          <?= htmlentities($comment->publishDate()) ?>
        </div>
        <div class="comment_content">
          <?= htmlentities($comment->content()) ?>
        </div>
      </div>
    <?php endforeach ?>
  <?php else : ?>
    <p>Soyez le premier à commenter.</p>
  <?php endif ?>
</div>

</div>
