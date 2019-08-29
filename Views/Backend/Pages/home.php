<?php $title = "Backoffice | Accueil"; ?>

<h2>Dashboard</h2>

<p>Il y a <a href="?page=posts"><?= htmlentities((string)$postsCount) ?> articles</a></p>
<p>Il y a <a href="?page=comments"><?= htmlentities((string)$commentCount) ?> commentaires<?= $uncheckedCount ? " / " . htmlentities((string)$uncheckedCount) . " non validés " : "" ?></a></p>

<?php if ($uncheckedComment) : ?>
  <h3>Commentaires à vérifier :</h3>
  <div class="table">
    <table>
      <tr>
        <th>ID Commentaire</th>
        <th>ID Article</th>
        <th>Auteur</th>
        <th>Commentaire</th>
        <th>Date de publication</th>
        <th>Action</th>
      </tr>

      <?php foreach ($uncheckedComment as $comment) : ?>
        <tr>
          <td><?= htmlentities((string)$comment->id()) ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= htmlentities((string)$comment->idArticle()) ?>"><?= htmlentities((string)$comment->idArticle()) ?></a></td>
          <td><?= htmlentities((string)$comment->author()) ?></td>
          <td><?= htmlentities((string)$comment->content()) ?></td>
          <td><?= htmlentities((string)$comment->publishDate()) ?></td>
          <td>
            <a href="?check=<?= htmlentities((string)$comment->id()) ?>&post=<?= htmlentities((string)$comment->idArticle()) ?>&token=<?= htmlentities((string)$token) ?>">Valider</a> /
            <a href="?flag=<?= htmlentities((string)$comment->id()) ?>&post=<?= htmlentities((string)$comment->idArticle()) ?>&token=<?= htmlentities((string)$token) ?>">Modérer</a>
          </td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>
