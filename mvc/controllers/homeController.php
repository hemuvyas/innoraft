<?php
class homeController {
  function __construct () {

  }
  function home () {
    include ('model/homeModel.php');
    include ('view/homeView.php');

  }
}
?>
