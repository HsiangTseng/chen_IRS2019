<html>
<p id="123">
  123
</p>

<script>
  var p1 ="succ";
</script>
<?php

  function a()
  {
    return "<script>document.writeln(p1);</script>";
  }

  $mm = a();
  echo $mm;
 ?>
</html>
