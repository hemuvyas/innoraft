<?php
if(isset($_SESSION['username'])){
  echo "<h3 class=text-center> WELCOME ".$_SESSION['username']."!! </h3>";
}
// include ('view/homeView.php');
while ( $temp = mysqli_fetch_array ($res) ) {
  $des = explode(" ",$temp['Des']);
  echo "<br>";
  echo "<div class='container'>";
  echo "<h1>  <a href='/mvc/index.php?controller=blog&function=show&id=".$temp['id']."'>".$temp['Title']."</a></h1>
  <br>
  <img src=/mvc/".$temp['image']." width='200px' height='200px'><br>
  <h5>".$temp['Des']."</h5>";
  // for($i=0;$i<20;$i++) {
  //   echo $des[$i]." ";
  // }
  // echo  "....<a style ='color:#57ff9f;' href='/mvc/index.php?controller=blog&function=show&id=".$temp['id']."'> Read More</a></h5>";

  if(isset ($_SESSION ['username']))
    if ($_SESSION['username'] == $temp['username']) {
      echo "<a href='/mvc/index.php?controller=user&function=edit&id=".$temp['id']."' class='btn btn-info float-right mx-3' style='margin-right: 10px;'>EDIT</a>";
      echo "<a href='/mvc/index.php?controller=user&function=delete&id=".$temp['id']."' class='btn btn-info float-right mx-3'>DELETE</a>";
    }
    echo "</div>";
  }

  ?>
