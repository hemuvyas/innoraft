<?php

class loginController {
 function login () {
   if(isset($_SESSION['username']))
    header ('location:/mvc/index.php?controller=user&function=myblogs');
  include ('view/loginView.php');

}
function validate() {
 include ('model/loginModel.php');
 while ($temp = mysqli_fetch_array ($res)) {
   if($temp['username'] == $_POST['username'] && $temp['password'] == $_POST['password']) {
    $_SESSION['username'] = $temp['username'];
    header('location: /mvc/index.php?controller=user&function=myblogs');
    break;
  }
  else {
   echo '<div class="alert alert-danger" role="alert">
   Wrong Username or password
   </div>';
   include ('view/loginView.php');

 }
}
}
function logout() {
 session_destroy();
 header ('location: /mvc/');
}

}

?>
