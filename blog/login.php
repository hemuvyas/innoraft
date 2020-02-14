<?php
/**
 * @file
 *  This file contains the code for login page of our blog site.
 */

// Connection file is included.
include 'connection.php';

// If session is set then on opening login page it will redirect to entry page for blogs
if (isset($_SESSION['uname'])) {
	echo "<script>location.href='entry.php'</script>";
}
else {

	// If session is not set and data is send through post method from login form itself then it checks for all the details and if correct then login the user.
	if (isset($_POST['nuser'])) {
		$username=$_POST['nuser'];
		$password=base64_encode($_POST['userp']);
		$sql="SELECT * FROM login WHERE username='".$username."' AND password='".$password."' LIMIT 1";
		$result=mysqli_query($conn, $sql);

		// If the login info is correct then session uname and time is set, which can be used  for autologout if time exceeds else incorrect details is printed.
		if (mysqli_num_rows($result)==1) {
			$_SESSION['uname']=$username;
			$_SESSION['maxtime']=time();
			echo "<script>location.href='entry.php'</script>";
		}
		else {
			echo "Incorrect Details";
			echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="blog_style.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
	<header>
		<ul>
			<li><a href="index.php">Home</a></li>
		</ul>
	</header>
	<h1>Please Login To Enter The Blog</h1>
	<!-- take input from user and check for correct credentials on same page -->
	<form method="post" action="login.php">
		Username:<input type="text" name="nuser" placeholder="admin"><br><br>
		Password:<input type="password" name="userp" placeholder="admin"><br><br>
		<input type="submit" name="login" value="Login">
	</form><br>
</body>
</html>
