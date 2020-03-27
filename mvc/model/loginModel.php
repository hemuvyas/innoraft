<?php

/**
 * @file
 * It fetches the data of the authentic users from the database.
 */

include ('connection.php');
mysqli_select_db($con, 'blog');
$q = "select * from user";
$res = mysqli_query ($con, $q);
?>
