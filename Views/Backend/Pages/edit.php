<? $title = "Backoffice | Edition"; ?>

<div class="post_edit">
  <h2>Edition d'un article</h2>
  <form class="" action="" method="post">
    <p><input type="hidden" name="t_user" value="<?= $token ?>"> </p>

    <?php if(isset($errors) && in_array(Post::AUTHOR_INVALID, $errors)) echo "<p class='alert warning'>auteur invalide</p>"; ?>
    <p><label for="author">Auteur</label><input type="text" name="author" value="<?= $post ? $post->author() : "" ?>"></p>

    <?php if(isset($errors) && in_array(Post::TITLE_INVALID, $errors)) echo "<p class='alert warning'>titre invalide</p>"; ?>
    <p><label for="title">Titre</label><input type="text" name="title" value="<?= $post ? $post->title() : "" ?>"></p>

    <?php if(isset($errors) && in_array(Post::KICKER_INVALID, $errors)) echo "<p class='alert warning'>chapeau invalide</p>"; ?>
    <p><label for="kicker">Chapeau</label><textarea name="kicker" rows="2" cols="80"><?= $post ? $post->kicker() : "" ?></textarea></p>

    <?php if(isset($errors) && in_array(Post::CONTENT_INVALID, $errors)) echo "<p class='alert warning'>Contenu invalide</p>"; ?>
    <p><label for="content">Contenu</label><textarea name="content" rows="8" cols="80"><?= $post ? $post->content() : "" ?></textarea></p>
    <?php if($post) : ?>
      <p><input type="hidden" name="id" value="<?= $post->id() ?>"> </p>
      <p><input type="submit" name="update" value="Modifier"></p>
    <?php else : ?>
      <p><input type="submit" name="add" value="Publier"></p>
    <?php endif ?>
  </form>
</div>
