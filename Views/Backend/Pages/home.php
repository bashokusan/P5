<? $title = "Backoffice | Accueil"; ?>

<h2>Dashboard</h2>

<p>Il y a <?= $postsCount ?> articles</p>
<p>Il y a <?= $commentCount ?> commentaires / <?= $uncheckedCount ?> non validés</p>

<h3>Commentaires à valider</h3>
<table border='1'>
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
      <td><?= $comment->idArticle() ?></td>
      <td><?= $comment->author() ?></td>
      <td><?= $comment->content() ?></td>
      <td><?= $comment->publishDate() ?></td>
      <td>
        <a href="?check=<?= $comment->id() ?>&post=<?= $comment->idArticle() ?>">Valider</a> /
        <a href="?flag=<?= $comment->id() ?>&post=<?= $comment->idArticle() ?>">Modérer</a>
      </td>
    </tr>
  <?php endforeach ?>

</table>
