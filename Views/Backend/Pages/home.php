<?php $title = "Backoffice | Accueil"; ?>

<h2>Dashboard</h2>

<p>Il y a <a href="?page=posts"><?= htmlentities($postsCount) ?> articles</a></p>
<p>Il y a <a href="?page=comments"><?= htmlentities($commentCount) ?> commentaires<?= $uncheckedCount ? " / " . htmlentities($uncheckedCount) . " non validés " : "" ?></a></p>

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
          <td><?= htmlentities($comment->id()) ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= htmlentities($comment->idArticle()) ?>"><?= htmlentities($comment->idArticle()) ?></a></td>
          <td><?= htmlentities($comment->author()) ?></td>
          <td><?= htmlentities($comment->content()) ?></td>
          <td><?= htmlentities($comment->publishDate()) ?></td>
          <td>
            <a href="?check=<?= htmlentities($comment->id()) ?>&post=<?= htmlentities($comment->idArticle()) ?>&token=<?= htmlentities($token) ?>">Valider</a> /
            <a href="?flag=<?= htmlentities($comment->id()) ?>&post=<?= htmlentities($comment->idArticle()) ?>&token=<?= htmlentities($token) ?>">Modérer</a>
          </td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>
