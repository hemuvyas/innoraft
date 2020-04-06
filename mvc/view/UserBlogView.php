<?php
namespace View;

/**
 * @file
 * This file contains the code to display a specific blog by it's id from url.
 */


/**
 *Class for view to display the data we get from model with proper authorities.
 */
class UserBlogView
{

  /**
   * Constructor checks if the user is logged in or not.
   */
  function __construct()
  {
    if (isset($_SESSION['username'])) {
      echo "<h3 class=text-center> WELCOME ".$_SESSION['username']."!! </h3>";
    }
  }

  /**
   * Shows the complete blog for the specified id.
   * @param mysqli_result $res
   *  The sql result we get from model.
   */
  public function DisplayId($res)
  {
    while ($temp = mysqli_fetch_array ($res)) {
      $des = explode(" ",$temp['Des']);
      echo "<br>";
      echo "<div class='container'>";
      echo "<h1>  <a href='/index.php?controller=Blog&function=show&id=".$temp['id']."'>".$temp['Title']."</a></h1>
      <br>
      <img src=/".$temp['image']." width='200px' height='200px'><br>
      <h5>".$temp['Des']."</h5>";
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
