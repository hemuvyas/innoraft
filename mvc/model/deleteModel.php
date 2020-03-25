<?php
include 'connection.php';
mysqli_select_db($con, 'blog');
$q = "DELETE FROM blog WHERE id = '$id'";
$res = mysqli_query ($con, $q);
?>
