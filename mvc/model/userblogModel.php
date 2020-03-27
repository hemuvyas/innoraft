<?php

/**
 * @file
 * Fetches the blog which were authored by user himself.
 */

include ('connection.php');
mysqli_select_db($con, 'blog');
$username = $_SESSION['username'];
$q = "select * from blog where username = '$username'";
$res = mysqli_query ($con, $q);
?>
