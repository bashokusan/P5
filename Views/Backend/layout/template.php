<?php

use App\Controllers\Menu;

$path = dirname(__DIR__). DIRECTORY_SEPARATOR . 'Sections' . DIRECTORY_SEPARATOR;

// <html><head>
require_once $path . 'header.php';

// <header> with the nav
$nav = new Menu();
if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
    $menu = $nav->menuBackAdmin();
} elseif (isset($_SESSION['role']) && $_SESSION['role'] == "guest") {
    $menu = $nav->menuBackGuest();
} else {
    $menu = $nav->menuBack();
}
require_once $path . 'topbar.php';

// Content of the page
echo "<div class='container'>";
echo $content;
echo "</div>";

// <footer>
require_once $path . 'footer.php';
