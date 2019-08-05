<?php $title = "Blog | " . $response->getTitle() ?>

<h2><?= $response->getTitle() ?></h2>
<p><em><?= $response->getPublishDate() ?></em></p>
<?= ($response->getUpdateDate()) ? "<p><em>" . $response->getUpdateDate() . "</em></p>" : ""; ?>
<p>Auteur</p>
<p><?= $response->getKicker() ?></p>
<p><?= $response->getContent() ?></p>
