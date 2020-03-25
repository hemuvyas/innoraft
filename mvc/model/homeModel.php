<?php
include ('connection.php');
mysqli_select_db($con, 'blog');
$q = 'select * from blog order by time desc';
$res = mysqli_query ($con, $q);
?>
