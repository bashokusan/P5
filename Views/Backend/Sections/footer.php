<footer>
  <p>Page chargée en <?= round((microtime(true) - LOADTIME) * 1000) ?>ms</p>
</footer>
<script>
  $(document).ready(function () {
      $(".fa-bars").click(function() {
          if($(".menu").first().is(":hidden")){
              $(".menu").slideDown("slow");
          }else {
              $(".menu").slideUp("slow");
          }

      });
  });
</script>
</body>
</html>
