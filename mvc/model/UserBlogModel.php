<?php
namespace Model;

use Model\Connect;
/**
 * @file
 * Fetches the blog which were authored by user himself.
 */

/**
 *Class handles all the business logic of the logged in user's blog.
 */
class UserBlogModel extends Connect
{

  /**
   * Displays all the data of blogs authored by user.
   * @return sql_result
   *  Sql result from the database.
   */
  public function BlogData()
  {
    $username = $_SESSION['username'];
    $q = "select * from blog where username = '$username'";
    $res = $this->con->query($q);
    return $res;
  }

  /**
   * Function to add the blog by the logged in user.
   * @param String $title
   *  Title of the blog.
   * @param String $des
   *  Description of the blog.
   * @param String $img_locate
   *  Location of the image in MVC folder.
   * @param Time $time
   *  Current time when the post is authored.
   * @param String $user
   *  Username that is logged in.
   * @return mixed
   *  Sql result of added blog.
   */
  public function AddData($title, $des, $img_locate, $time, $user)
  {
    $q = "INSERT INTO `blog` (`Title`, `Des`, `image`, `time`,  `username`) VALUES ('$title', '".$des."', '$img_locate' ,'$time', '$user')";
    $res = $this->con->query($q);
    echo mysqli_error($con);
    return $res;
  }

   /**
   * Function to edit the blog by the logged in user.
   * @param String $title
   *  Title of the blog.
   * @param String $des
   *  Description of the blog.
   * @param String $img_locate
   *  Location of the image in MVC folder.
   * @param Time $time
   *  Current time when the post is authored.
   * @param Int $id
   *  Blog's unique id.
   * @return mixed
   *  Sql result of edited blog.
   */
  public function EditData($title, $des, $img_locate, $time, $id)
  {
    if ($_FILES['pic']) {
      $q = "UPDATE blog
      SET Title = '$title', Des= '$des', time = '$time', image = '$img_locate'
      WHERE id = $id";
    }
    else {
      $q = "UPDATE blog
      SET Title = '$title', Des= '$des', time = '$time'
      WHERE id = $id";
    }
    $res = $this->con->query($q);
    echo mysqli_error($con);
    return $res;
  }

  /**
   * Deletes the blog from database for specified id.
   * @param Int $id
   *  Unique id of the blog.
   */
  public function DeleteData($id)
  {
    $q = "DELETE FROM blog WHERE id = '$id'";
    $res = $this->con->query($q);
  }
}

?>
