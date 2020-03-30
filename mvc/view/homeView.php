<?php

/**
 * @file
 * It displays the fetched data on the home page of site.
 */


/**
 *Class displays the home page after getting the required data from model.
 */
class HomeView
{

  function __construct()
  {

  }

  /**
   * Function displays the blocks in specified manner.
   * @param  Sql_result $res
   *  Sql result from model layer.
   * @return mixed
   *  Renders the home page.
   */
  public function display($res)
  {
    while ($temp = mysqli_fetch_array ($res)) {
      echo "<div class='container'>";
      echo "<h1>  <a href='/index.php?controller=Blog&function=show&id=".$temp['id']."'>".$temp['Title']."</a></h1>
      </a>
      <hr>
      <h5>";
      $des = explode(" ",$temp['Des']);
      if (isset($des[19])) {
        for ($i=0;$i<20;$i++) {
          echo $des[$i]." ";
        }
        echo  "....<a style ='color:#57ff9f;' href='/index.php?controller=Blog&function=show&id=".$temp['id']."'> Read More</a></h5>";
      }
      else {
        echo  "<a style ='color:black; text-decoration: none;' href='/index.php?controller=Blog&function=show&id=".$temp['id']."'> ".$temp['Des']."</a></h5>";
      }
      $this->checkuser($temp['username'], $temp['id']);
      echo "</div>";
    }
  }

  /**
   * Checks if user and the author of the blog is same or not, and then provide authorities.
   * @param  String $user
   *  User who is logged in.
   * @param  int $id
   *  Id of the blog.
   * @return mixed
   *  Shows the Edit and Delete options based on logged-in user.
   */
  public function checkuser($user, $id)
  {
    if (isset ($_SESSION ['username'])) {
      if ($_SESSION['username'] == $user) {
        echo "<a href='/index.php?controller=User&function=edit&id=" . $id . "' class='btn btn-info float-right mx-3' style='margin-right: 10px;'>EDIT</a>";
        echo "<a href='/index.php?controller=User&function=delete&id=" . $id . "' class='btn btn-info float-right mx-3'>DELETE</a>";
      }
    }
  }

}
?>
