<?php
namespace Model;

use Model\Connect;
/**
 * @file
 * It fetches the data of all blogs to be displayed on the homepage to users.
 */

/**
 *Class fetches data for home page's business logic.
 */
class HomeModel extends Connect
{

  /**
   * Fetched the business data for home page.
   * @return mixed
   *  Sql query result.
   */
  function data() {
    $q = 'select * from blog order by time desc';
    $res = $this->con->query($q);
    return $res;
  }

}


?>
