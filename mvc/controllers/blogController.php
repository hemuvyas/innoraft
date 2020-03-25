<?php
class blogController {
  function show () {
    include ('model/blogModel.php');
    include ('view/userblogView.php');
  }
}
?>
