<footer>
  <p>Page chargée en <?= round((microtime(true) - LOADTIME) * 1000) ?>ms</p>
  <?php if(isset($_SESSION) && !empty($_SESSION)) : ?>
    <p><?= 'u_log :'.$_SESSION['u_log'].' / t_user :'.$_SESSION['t_user'] ?></p>
    <p><?= 'role :'.$_SESSION['role'].' / id :'.$_SESSION['id'] ?></p>
    <p><?= 'u_log cookie :'.$_COOKIE['u_log'] ?></p>
  <?php endif ?>
</footer>
</body>
</html>
