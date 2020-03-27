<?php

/**
 * @file
 * This file contains the code for blog controller, which is used to display blog with specific id for blog.
 */

class BlogController {

  function show () {
    include ('model/blogModel.php');
    include ('view/userblogView.php');
  }

}
?>
