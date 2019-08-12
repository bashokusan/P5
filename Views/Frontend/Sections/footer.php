<?php if(true) : ?>
<footer>
  <a href="?page=admin">Administration</a>
  <ul class="social">
    <li><a href="https://github.com/bashokusan"><i class="fab fa-github fa-lg" aria-hidden=true></i></a></li>
    <li><a href="https://www.linkedin.com/in/simonnetpierre"><i class="fab fa-linkedin-in fa-lg" aria-hidden=true></i></a></li>
    <li><a href="https://www.instagram.com/pierre_bashoku/"><i class="fab fa-instagram fa-lg" aria-hidden=true></i></a></li>
  </ul>
  <p>Page chargée en <?= round((microtime(true) - LOADTIME) * 1000) ?>ms</p>
</footer>
<?php endif ?>
</body>
</html>
