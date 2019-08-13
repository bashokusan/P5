<footer>
  <p>Page chargée en <?= round((microtime(true) - LOADTIME) * 1000) ?>ms</p>
  <p>Referer : <?= $_SERVER['HTTP_REFERER'] ?></p>
  <?php dd($_SESSION) ?>
</footer>
</body>
</html>
