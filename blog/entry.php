<?php
/**
 * @file
 *  This file contains the code for entering the blog by the admin.
 */

// Connection file with database is included.
include 'connection.php';

// Checks if user is logged or not by checking session variable.
if (isset($_SESSION['uname'])) {

	// If user is logged and the time is passed more then 1000 millisec then user will be logged out, else his new time is stored in session maxtime variable.
	if ((time()-$_SESSION['maxtime'])>1000) {
		echo "<script>location.href='logout.php'</script>";
	}
	else{
		$_SESSION['maxtime']=time();
	}
}

// If user is not logged then redirect to login page.
else{
	echo "<script>location.href='login.php'</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="blog_style.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
	<title>Entry for Blogs</title>
</head>
<body>
	<header>
		<ul>
			<li><a href="logout.php">Logout</a></li>
			<li><a href="index.php" class="right">Home</a></li>
		</ul>
	</header>
	<main>
		<div class='heading'>
			<h1>Please enter the data for your blog site.</h1>
		</div>
		<div class="form">

			<!-- Data to enter in the database is send through this form. -->
			<form action='entry.php' method="post" enctype="multipart/form-data">
				<label>Title :</label><input type="text" name="title" placeholder="Title of the blog"><br><br>
				<label>Image :</label><input type="file" name="img" required><br><br>
				<label>Description :</label><textarea name="desc" rows="5" cols="40"></textarea><br><br>
				<input type="submit" name="submit" value="Submit">
			</form>
		</div>
	</main>
</body>
</html>
<?php
$title=$img=$desc='';

// Checks if data is only sent through POST method and submit button is pressed.
if ($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['submit'])) {

	// Checks if title or description of the blog is empty or not.
	if (empty($_POST['title']) || empty($_POST['desc'])) {
		echo "Cannot Leave blank";
		echo "<script>setTimeout(\"location.href = 'entry.php';\",1500);</script>";
	}
	else {

		// File path for the image and other data is being stored in the variables.
		$filepath = "image/" . basename($_FILES["img"]["name"]);
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$img = $_FILES['img']['name'];
		if (move_uploaded_file($_FILES["img"]["tmp_name"], $filepath)) {

			// It inserts the data into our database.
			$sql_insert = "INSERT INTO data (Title, image, Description)VALUES ('$title', '$img', '$desc')";
			$resulti=mysqli_query($conn, $sql_insert);

			// If inserted successfully then success message is displayed else mysql error is displayed.
			if ($resulti) {
				echo "Inserted Successfully";
			}
			else {
				echo mysqli_error($conn);
			}
		}
		else {
			echo "There is a problem";
		}

	}
}
?>
