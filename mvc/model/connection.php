<?php

/**
 * @file
 * It contains the connection file code of MVC blogs.
 */

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
