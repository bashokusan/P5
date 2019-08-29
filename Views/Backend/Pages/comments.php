<?php $title = "Backoffice | Commentaires"; ?>

<h2>Commentaires</h2>

<?php if ($flagCommentsCount): ?>
  <h3>Commentaires modérés</h3>
  <p><?= htmlentities($flagCommentsCount) ?> commentaires modérés</p>
  <div class="table">
    <table>
      <tr>
        <th>ID Commentaire</th>
        <th>ID Article</th>
        <th>Auteur</th>
        <th>Commentaire</th>
        <th>Date de publication</th>
      </tr>

      <?php foreach ($flagComments as $comment) : ?>
        <tr>
          <td><?= htmlentities($comment->id()) ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= htmlentities($comment->idArticle()) ?>"><?= htmlentities($comment->idArticle()) ?></a></td>
          <td><?= htmlentities($comment->author()) ?></td>
          <td><?= htmlentities($comment->content()) ?></td>
          <td><?= htmlentities($comment->publishDate()) ?></td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>

<?php if ($checkedCommentsCount): ?>
  <h3>Commentaires validés</h3>
  <p><?= htmlentities($checkedCommentsCount) ?> commentaires validés</p>
  <div class="table">
    <table>
      <tr>
        <th>ID Commentaire</th>
        <th>ID Article</th>
        <th>Auteur</th>
        <th>Commentaire</th>
        <th>Date de publication</th>
      </tr>

      <?php foreach ($checkedComment as $comment) : ?>
        <tr>
          <td><?= htmlentities($comment->id()) ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= htmlentities($comment->idArticle()) ?>"><?= htmlentities($comment->idArticle()) ?></a></td>
          <td><?= htmlentities($comment->author()) ?></td>
          <td><?= htmlentities($comment->content()) ?></td>
          <td><?= htmlentities($comment->publishDate()) ?></td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>
