<?php
/**
 * @file
 *  It contains the details of the connection wih the database
 */
$host="localhost";
$user="root";
$pass="";
$db="blog";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?>