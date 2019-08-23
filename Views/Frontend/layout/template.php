<?php

use App\Models\Menu;

$path = dirname(__DIR__). DIRECTORY_SEPARATOR . 'Sections' . DIRECTORY_SEPARATOR;

// <html><head>
require_once $path . 'header.php';

// <header> with the nav
$nav = new Menu();
$menu = $nav->menuFront();
require_once $path . 'topbar.php';

// Content of the page
echo "<div class='container'>";
echo $content;
echo "</div>";

// <footer>
require_once $path . 'footer.php';
