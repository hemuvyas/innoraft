<?php
include ('connection.php');
$id = $_GET['id'];
$username = $_SESSION['username'];
mysqli_select_db($con, 'blog');
if($_FILES['pic']){
  $q = "UPDATE blog
  SET Title = '$title', Des= '$des', time = '$time', image = '$img_locate'
  WHERE id = $id";
}
else{
  $q = "UPDATE blog
  SET Title = '$title', Des= '$des', time = '$time'
  WHERE id = $id";
}
$res = mysqli_query ($con, $q);
echo mysqli_error($con);
?>
