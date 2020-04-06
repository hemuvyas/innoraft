<?php
namespace Controller;

use Model\BlogModel;
use View\UserBlogView;
/**
 * @file
 * This file contains the code for blog controller, which is used to display blog with specific id for blog.
 */

/**
 * Class is defined to get data for a blog with its specific id.
 */
class BlogController {

  /**
   * Function to get model blog and it's view.
   * @return mixed Showing only that blog with specific id.
   */
  function show () {
    $model = new BlogModel();
    $res = $model->BlogForId($_GET['id']);
    $view = new UserBlogView();
    $view->DisplayId($res);
  }

}
?>
