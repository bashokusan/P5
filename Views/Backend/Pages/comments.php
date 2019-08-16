<? $title = "Backoffice | Commentaires"; ?>

<h2>Commentaires</h2>

<h3>Commentaires modérés</h3>
<p><?= $flagCommentsCount ?> commentaires modérés</p>

  <table border='1'>
    <tr>
      <th>ID Commentaire</th>
      <th>ID Article</th>
      <th>Auteur</th>
      <th>Commentaire</th>
      <th>Date de publication</th>
    </tr>

    <?php foreach($flagComments as $comment) : ?>
      <tr>
        <td><?= $comment->id() ?></td>
        <td><?= $comment->idArticle() ?></td>
        <td><?= $comment->author() ?></td>
        <td><?= $comment->content() ?></td>
        <td><?= $comment->publishDate() ?></td>
      </tr>
    <?php endforeach ?>

  </table>

<h3>Commentaires vérifiés</h3>
<p><?= $checkedCommentsCount ?> commentaires vérifiés</p>

  <table border='1'>
    <tr>
      <th>ID Commentaire</th>
      <th>ID Article</th>
      <th>Auteur</th>
      <th>Commentaire</th>
      <th>Date de publication</th>
    </tr>

    <?php foreach($checkedComment as $comment) : ?>
      <tr>
        <td><?= $comment->id() ?></td>
        <td><?= $comment->idArticle() ?></td>
        <td><?= $comment->author() ?></td>
        <td><?= $comment->content() ?></td>
        <td><?= $comment->publishDate() ?></td>
      </tr>
    <?php endforeach ?>

  </table>

<h3>Tous les commentaires</h3>
<p><?= $CommentsCount ?> commentaires</p>

  <table border='1'>
    <tr>
      <th>ID Commentaire</th>
      <th>ID Article</th>
      <th>Auteur</th>
      <th>Commentaire</th>
      <th>Date de publication</th>
    </tr>

    <?php foreach($commentsList as $comment) : ?>
      <tr>
        <td><?= $comment->id() ?></td>
        <td><?= $comment->idArticle() ?></td>
        <td><?= $comment->author() ?></td>
        <td><?= $comment->content() ?></td>
        <td><?= $comment->publishDate() ?></td>
      </tr>
    <?php endforeach ?>

  </table>
