<?php

/**
 * @file
 * Inserts the data into the database.
 */

include ('connection.php');
$username = $_SESSION['username'];
mysqli_select_db($con, 'blog');
$q = "INSERT INTO `blog` (`Title`, `Des`, `image`, `time`,  `username`) VALUES ('$title', '".$des."', '$img_locate' ,'$time', '$username')";
$res = mysqli_query ($con, $q);
echo mysqli_error($con);
?>
