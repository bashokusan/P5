<?php $title = "Backoffice | Edition"; ?>

<div class="post_edit">
  <h2>Edition d'un article</h2>
  <form class="edit_form" action="" method="post" enctype="multipart/form-data">
    <p><input type="hidden" name="t_user" value="<?= $token ?>"> </p>

    <p>
      <label for="author">Auteur</label>
      <?php if (isset($errors) && in_array(App\Models\Post::IDAUTHOR_INVALID, $errors)) : ?>
        <p class='alert warning'>auteur invalide</p>
      <?php endif ?>
      <select class="userslist" name="idauthor">
        <?php if ($users) : ?>
          <?php foreach ($users as $user) : ?>
            <option value="<?= htmlentities($user->id()) ?>"
            <?php
              if ($post && ($post->name() == $user->name())) {
                  echo "selected";
              } elseif ($user->name() == $loggedinUser->name()) {
                  echo "selected";
              }
            ?>><?= htmlentities($user->name()) ?></option>
          <?php endforeach ?>
        <?php endif ?>
        </select>
    </p>

    <p>
      <label for="title">Titre</label>
      <?php if (isset($errors) && in_array(App\Models\Post::TITLE_INVALID, $errors)) : ?>
        <p class='alert warning'>titre invalide</p>
      <?php endif ?>
      <?php if (isset($errors) && in_array(App\Models\Post::TITLE_LENGHT, $errors)) : ?>
        <p class='alert warning'>Le titre doit faire au moins 10 caractères</p>
      <?php endif ?>
      <input type="text" name="title" value="<?php if ($post) {
                echo htmlentities($post->title());
          } ?>">
    </p>

    <p>
      <label for="kicker">Chapeau</label>
      <?php if (isset($errors) && in_array(App\Models\Post::KICKER_INVALID, $errors)) : ?>
        <p class='alert warning'>chapeau invalide</p>
      <?php endif ?>
      <?php if (isset($errors) && in_array(App\Models\Post::KICKER_LENGHT, $errors)) : ?>
        <p class='alert warning'>Le chapeau doit faire au moins 10 caractères</p>
      <?php endif ?>
      <textarea name="kicker" rows="2" cols="80"><?php if ($post) {
          echo htmlentities($post->kicker());
      }?></textarea>
    </p>

    <p>
      <label for="content">Contenu</label>
      <?php if (isset($errors) && in_array(App\Models\Post::CONTENT_INVALID, $errors)) : ?>
        <p class='alert warning'>Contenu invalide</p>
      <?php endif ?>
      <?php if (isset($errors) && in_array(App\Models\Post::CONTENT_LENGHT, $errors)) : ?>
        <p class='alert warning'>L'article doit faire au moins 100 caractères</p>
      <?php endif ?>
      <textarea name="content" rows="8" cols="80"><?php if ($post) {
          echo htmlentities($post->content());
      }?></textarea>
    </p>

    <?php if ($post) : ?>
      <p>
        <input type="hidden" name="id" value="<?= htmlentities($post->id()) ?>">
      </p>
      <p>
        <input type="submit" name="update" value="Modifier">
      </p>
    <?php else : ?>
      <p>
        <input type="submit" name="add" value="Publier">
      </p>
    <?php endif ?>
  </form>
</div>
