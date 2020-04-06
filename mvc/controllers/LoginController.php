<?php
namespace Controller;

use Model\LoginModel;
/**
 * @file
 * It contains the functions related to login, logout and validations for the users.
 */

/**
 * Class that handles the login related operation of MVC project.
 */
class LoginController {

  /**
   * If user logged in then redirect to his own blogs page.
   */
  function login() {
   if (isset($_SESSION['username'])) {
    header ('location:/index.php?controller=User&function=myblogs');
    }
    else {
      include ('view/loginView.php');
    }
  }

/**
 * If user credentials are correct then redirect to his own blogs page else enter the details again.
 * @return mixed
 *  Redirects user based on his entered credentials.
 */
function validate() {
 $model = new LoginModel();
 $res = $model->logindata();
 $user = $_POST['username'];
 $pass = $_POST['password'];
 $model->checkuser($res, $user, $pass);
}

//
/**
 * When user logout destroy its session and redirect to home page.
 * @return mixed
 *  Destroys session and redirect to homepage.
 */
function logout() {
 session_destroy();
 header ('location: /');
}

}

?>
