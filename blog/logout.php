<?php
session_start();
//if session is set or user logged in then destroy the session and redirect to login page
if (isset($_SESSION['uname'])) {
	session_destroy();
	echo "<script>location.href='login.php'</script>";
}
//if session is not set then directly redirect to login page
else
{
	echo "<script>location.href='login.php'</script>";
}
?>