<?php

/**
 * @file
 * It fetchs the data of blog to be displayed.
 */

/**
 * Class to fetch business logi for blog with specified id passed.
 */
class BlogModel
{

  function __construct()
  {

  }

  /**
   * Fetches data from database by passed id.
   * @param int $id
   * Id of a blog.
   *
   * @return mixed mysqli result.
   */
  public function BlogForId($id)
  {
    include 'connection.php';
    mysqli_select_db($con, 'blog');
    $q = "select * from blog where id ='".$id."'";
    $res = mysqli_query ($con, $q);
    return $res;
  }
}


?>
