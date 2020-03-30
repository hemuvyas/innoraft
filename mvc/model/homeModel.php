<?php

/**
 * @file
 * It fetches the data of all blogs to be displayed on the homepage to users.
 */


/**
 *Class fetches data for home page's business logic.
 */
class HomeModel
{

  function __construct()
  {

  }

  /**
   * Fetched the business data for home page.
   * @return mixed
   *  Sql query result.
   */
  function data() {
    include ('connection.php');
    mysqli_select_db($con, 'blog');
    $q = 'select * from blog order by time desc';
    $res = mysqli_query ($con, $q);
    return $res;
  }

}


?>
