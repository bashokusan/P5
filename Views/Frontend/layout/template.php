<?php

use App\Controllers\Helpers\Menu;

$path = dirname(__DIR__). DIRECTORY_SEPARATOR . 'Sections' . DIRECTORY_SEPARATOR;

// <html><head>
require_once $path . 'header.php';

// <header> with the nav
$nav = new Menu();
$menu = $nav->menuFront();
require_once $path . 'topbar.php';

// Content of the page
?>
<div class='container'>
<?= $content; ?>
</div>
<?php

// <footer>
require_once $path . 'footer.php';
