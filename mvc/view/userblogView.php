<?php

/**
 * @file
 * This file contains the code to display a specific blog by it's id from url.
 */

//Checks if the user logged in or not.
if (isset($_SESSION['username'])) {
  echo "<h3 class=text-center> WELCOME ".$_SESSION['username']."!! </h3>";
}

// Showing the blog with its full details.
while ($temp = mysqli_fetch_array ($res)) {
  $des = explode(" ",$temp['Des']);
  echo "<br>";
  echo "<div class='container'>";
  echo "<h1>  <a href='/mvc/index.php?controller=Blog&function=show&id=".$temp['id']."'>".$temp['Title']."</a></h1>
  <br>
  <img src=/mvc/".$temp['image']." width='200px' height='200px'><br>
  <h5>".$temp['Des']."</h5>";

// Checks if the author is same or diff, if same then edit and delete options are provided.
  if (isset ($_SESSION ['username']))
    if ($_SESSION['username'] == $temp['username']) {
      echo "<a href='/mvc/index.php?controller=User&function=edit&id=".$temp['id']."' class='btn btn-info float-right mx-3' style='margin-right: 10px;'>EDIT</a>";
      echo "<a href='/mvc/index.php?controller=User&function=delete&id=".$temp['id']."' class='btn btn-info float-right mx-3'>DELETE</a>";
    }
    echo "</div>";
  }

  ?>
