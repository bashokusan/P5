<?php

$path = dirname(__DIR__). DIRECTORY_SEPARATOR . 'Sections' . DIRECTORY_SEPARATOR;

require_once $path . 'header.php';

require_once $path . 'menu.php';

echo "<div class='container'>";
echo $content;
echo "</div>";

require_once $path . 'footer.php';
