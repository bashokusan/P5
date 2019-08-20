<? $title = "Backoffice | Accueil"; ?>

<h2>Dashboard</h2>

<p>Il y a <a href="?page=posts"><?= $postsCount ?> articles</a></p>
<p>Il y a <a href="?page=comments"><?= $commentCount ?> commentaires<?= $uncheckedCount ? " / " . $uncheckedCount . " non validés " : "" ?></a></p>

<?php if($uncheckedComment) : ?>
  <h3>Commentaires à valider :</h3>
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

      <?php foreach($uncheckedComment as $comment) : ?>
        <tr>
          <td><?= $comment->id() ?></td>
          <td><a href="../Public/index.php?page=article&id=<?= $comment->idArticle() ?>"><?= $comment->idArticle() ?></a></td>
          <td><?= $comment->author() ?></td>
          <td><?= $comment->content() ?></td>
          <td><?= $comment->publishDate() ?></td>
          <td>
            <a href="?check=<?= $comment->id() ?>&post=<?= $comment->idArticle() ?>&token=<?= $token ?>">Valider</a> /
            <a href="?flag=<?= $comment->id() ?>&post=<?= $comment->idArticle() ?>&token=<?= $token ?>">Modérer</a>
          </td>
        </tr>
      <?php endforeach ?>

    </table>
  </div>
<?php endif ?>
