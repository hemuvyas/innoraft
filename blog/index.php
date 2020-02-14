<?php
/**
 * @file
 *  This file contains the code for displaying the blogs on our site from the database.
 */

// Connection file is included.
include 'connection.php';

// Page no. is send through GET method, if not set then default page no. is 1.
if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
}
else {
	$page_no = 1;
}

// Total records to be displayed on a page is stored in this variable.
$total_records_per_page = 10;

// Offset value is calculated by total records and page no. with the iven formulae.
$offset = ($page_no-1) * $total_records_per_page;
$blog_index = ($page_no-1) * $total_records_per_page + 1;

// Total no. of blogs are calculated from the database.
$result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM data");
$total_records = mysqli_fetch_array($result_count);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;
if (isset($_SESSION['uname'])) {
	$user="Enter a new blog";
}
else {
	$user='Login';
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="blog_style.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
	<title>Home page</title>
</head>
<body>
	<header>
		<ul>
			<li><a href="login.php"><?php echo $user; ?></a></li>
			<?php
			if (isset($_SESSION['uname'])) {
				echo "<li><a href='logout.php'>Logout</a></li>";
			}
			?>
		</ul>
	</header>
	<main>
		<div class="heading">
			<h1>Welcome to our blog site</h1>
		</div>
		<div class="content">
			<div class="outline">
				<?php
				$sql="SELECT * FROM data ORDER BY Bid DESC LIMIT $offset, $total_records_per_page";
				$result=mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) >= 1) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<div class='block'>";
						echo "<div class='title'>";
						echo $blog_index."<a href='display.php?blog_no=".$row['Bid']."'> ".$row['Title']."</a>";
						echo "<div class='time'>";
						echo "Updated on ".$row['entry_date'];
						echo "</div>";
						echo "</div>";
						echo "<div class='desc'>";
						$string=$row['Description'];
						if (strlen($string) > 100) {

    						// String is cutted by last space between words after 100 characters length.
							$stringCut = substr($string, 0, 100);
							$endPoint = strrpos($stringCut, ' ');

    						// If the string doesn't contain any space then it will cut without word basis.
							$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
							$string .= "... <a href='display.php?blog_no=".$row['Bid']."'>Read More</a>";
						}
						echo $string;
						echo "</div>";
						echo "</div>";
						$blog_index++;
					}
				}
				?>
			</div>
		</div>
		<div class="footer">
			<div class="center">
				<div class="pagination">
					<?php
					if ($total_no_of_pages > 1) {
						for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
							if ($counter == $page_no) {
								echo "<a class='active'>$counter</a>";
							}
							else {
								echo "<a href='?page_no=$counter'>$counter</a>";
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</main>
</body>
</html>
