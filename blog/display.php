<?php
/**
 * @file
 *  This file contains the code for displaying the complete blog.
 */

// Connection file with database is included.
include 'connection.php';

// If blog no. through GET method is set then we open that blog else default blog no. is 1
if (isset($_GET['blog_no']) && $_GET['blog_no'] != "") {
	$blog_no = $_GET['blog_no'];
}
else {
	$blog_no = 1;
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="blog_style.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
	<title>Blog Content</title>
</head>
<body>
	<header>
		<ul>
			<li><a href="index.php">Home</a></li>
		</ul>
	</header>
	<main>
		<div style="text-align: center;">
			<h1>Complete Blog</h1>
		</div>
		<div class="display">
			<?php

			// Specified blog with Blog id by GET method is fetched through database.
			$sql="SELECT * FROM data WHERE Bid='".$blog_no."'";
			$result=mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) >= 1) {

				// Data is displayed in appropriate div classes from the database.
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<div class='title'>";
					echo $row['Title'];
					echo "<div class='time'>";
					echo "Updated on ".$row['entry_date'];
					echo "</div>";
					echo "</div>";
					echo "<div class='image'>";
					echo "<img src=image/".$row['image']." alt='Blog Image' height='100' width='100'>";
					echo "</div>";
					echo "<div class='desc'>";
					echo $row['Description'];
					echo "</div>";
				}
			}
			?>
		</div>
	</main>
</body>
</html>
