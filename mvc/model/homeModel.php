<?php

/**
 * @file
 * It fetches the data of all blogs to be displayed on the homepage to users.
 */

include ('connection.php');
mysqli_select_db($con, 'blog');
$q = 'select * from blog order by time desc';
$res = mysqli_query ($con, $q);
?>
