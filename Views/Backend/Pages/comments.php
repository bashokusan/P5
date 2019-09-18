<?php $title = "Backoffice | Commentaires"; ?>

<h2>Commentaires</h2>

<div class="table">
  <table>
    <tr>
      <th>ID Commentaire</th>
      <th>ID Article</th>
      <th>Auteur</th>
      <th>Commentaire</th>
      <th>Date de publication</th>
    </tr>
    <?php foreach ($commentsList as $comment) : ?>
      <tr>
        <td><?= $comment->id() ?></td>
        <td><a href="../Public/index.php?page=article&id=<?= $comment->idArticle() ?>"><?= $comment->idArticle() ?></a></td>
        <td><?= $comment->author() ?></td>
        <td class="<?php if ($comment->checked() == 1) : ?>valid<?php elseif ($comment->checked() == 2) : ?>flag<?php endif ?>"><?= $comment->content() ?></td>
        <td><?= $comment->publishDate() ?></td>
      </tr>
    <?php endforeach ?>

  </table>
</div>
