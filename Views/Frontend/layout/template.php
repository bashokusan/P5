<?php

$path = dirname(__DIR__). DIRECTORY_SEPARATOR . 'Sections' . DIRECTORY_SEPARATOR;

// <html><head>
require_once $path . 'header.php';

// <header> with the nav
require_once $path . 'menu.php';

// Content of the page
echo "<div class='container'>";
echo $content;
echo "</div>";

// <footer>
require_once $path . 'footer.php';
