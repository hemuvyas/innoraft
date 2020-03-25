<?php
  include ('connection.php');
  mysqli_select_db($con, 'blog');
  $q = "select * from user";
  $res = mysqli_query ($con, $q);
?>
