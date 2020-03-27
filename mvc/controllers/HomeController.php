<?php

/**
 * @file
 * This is the controller of home file.
 */

class HomeController {
  function __construct () {

  }
  function home() {
    include ('model/homeModel.php');
    include ('view/homeView.php');

  }
}
?>
