<?php $title = $response->getTitle() ?>

<h2><?= $response->getTitle() ?></h2>
<em><?= $response->getPublishDate() ?></em><em>, modifié le <?= $response->getUpdateDate() ?></em>
<p>Auteur</p>
<p><?= $response->getKicker() ?></p>
<p><?= $response->getContent() ?></p>
