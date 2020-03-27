<?php

/**
 * @file
 * It displays the fetched data on the home page of site.
 */

// Displays the fetched data.
while ($temp = mysqli_fetch_array ($res)) {
  $des = explode(" ",$temp['Des']);
  echo "<div class='container'>";
  echo "<h1>  <a href='/mvc/index.php?controller=Blog&function=show&id=".$temp['id']."'>".$temp['Title']."</a></h1>
  </a>
  <hr>
  <h5>";

  // Checks if the content to be displayed shoulb be trimmed or not.
  if (isset($des[19])) {
    for ($i=0;$i<20;$i++) {
      echo $des[$i]." ";
    }
    echo  "....<a style ='color:#57ff9f;' href='/mvc/index.php?controller=Blog&function=show&id=".$temp['id']."'> Read More</a></h5>";
  }
  else {
    echo  "<a style ='color:black; text-decoration: none;' href='/mvc/index.php?controller=Blog&function=show&id=".$temp['id']."'> ".$temp['Des']."</a></h5>";
  }

  // Checks if the author is same the give EDIT and DELETE priviliges.
  if (isset ($_SESSION ['username'])) {
    if ($_SESSION['username'] == $temp['username']) {
      echo "<a href='/mvc/index.php?controller=User&function=edit&id=".$temp['id']."' class='btn btn-info float-right mx-3' style='margin-right: 10px;'>EDIT</a>";
      echo "<a href='/mvc/index.php?controller=User&function=delete&id=".$temp['id']."' class='btn btn-info float-right mx-3'>DELETE</a>";
    }
  }
  echo "</div>";
}


?>
