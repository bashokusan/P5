<?php $title = "Backoffice | Commentaires"; ?>

<h2>Commentaires</h2>

<?php if ($flagCommentsCount): ?>
  <h3>Commentaires modérés</h3>
  <p><?= htmlentities((string)$flagCommentsCount) ?> commentaires modérés</p>
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
          <td><?= htmlentities((string)$comment->id()) ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= htmlentities((string)$comment->idArticle()) ?>"><?= htmlentities((string)$comment->idArticle()) ?></a></td>
          <td><?= htmlentities((string)$comment->author()) ?></td>
          <td><?= htmlentities((string)$comment->content()) ?></td>
          <td><?= htmlentities((string)$comment->publishDate()) ?></td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>

<?php if ($checkedCommentsCount): ?>
  <h3>Commentaires validés</h3>
  <p><?= htmlentities((string)$checkedCommentsCount) ?> commentaires validés</p>
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
          <td><?= htmlentities((string)$comment->id()) ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= htmlentities((string)$comment->idArticle()) ?>"><?= htmlentities((string)$comment->idArticle()) ?></a></td>
          <td><?= htmlentities((string)$comment->author()) ?></td>
          <td><?= htmlentities((string)$comment->content()) ?></td>
          <td><?= htmlentities((string)$comment->publishDate()) ?></td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>
