<?php
include 'connection.php';
mysqli_select_db($con, 'blog');
$id = $_GET['id'];
$q = "select * from blog where id ='".$id."'";
$res = mysqli_query ($con, $q);
 ?>
