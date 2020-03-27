<?php

/**
 * @file
 * It contains the functions related to login, logout and validations for the users.
 */

class LoginController {

  // If user logged in then redirect to his own blogs page.
  function login() {
   if (isset($_SESSION['username'])) {
    header ('location:/mvc/index.php?controller=User&function=myblogs');
    }
    else {
      include ('view/loginView.php');
    }
  }

// If user credentials are correct then redirect to his own blogs page else enter the details again.
function validate($abc) {
 include ('model/loginModel.php');
 while ($temp = mysqli_fetch_array ($res)) {
   if ($temp['username'] == $_POST['username'] && $temp['password'] == $_POST['password']) {
    $_SESSION['username'] = $temp['username'];
    header('location: /mvc/index.php?controller=User&function=myblogs');
    break;
    }
    else {
      echo '<div class="alert alert-danger" role="alert">Wrong Username or password</div>';
      include ('view/loginView.php');
    }
  }
}

// When user logout destroy its session and redirect to home page.
function logout() {
 session_destroy();
 header ('location: /mvc/');
}

}

?>
