<?php
namespace Model;

use Model\Connect;
/**
 * @file
 * It fetchs the data of blog to be displayed.
 */

/**
 * Class to fetch business logi for blog with specified id passed.
 */
class BlogModel extends Connect
{

  /**
   * Fetches data from database by passed id.
   * @param int $id
   * Id of a blog.
   *
   * @return mixed mysqli result.
   */
  public function BlogForId($id)
  {

    $q = "select * from blog where id ='".$id."'";
    $res = $this->con->query($q);
    return $res;
  }
}


?>
