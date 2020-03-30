<?php

/**
 * @file
 * It fetches the data of the authentic users from the database.
 */

/**
 *Class that fetches data for a user's login credentials from database.
 */
class LoginModel
{

  function __construct()
  {

  }

  /**
   * Gets the business logic for login of a user.
   * @return sql_result
   *  User ids and their respective passwords for the validation.
   */
  public function logindata()
  {
    include ('connection.php');
    mysqli_select_db($con, 'blog');
    $q = "select * from user";
    $res = mysqli_query ($con, $q);
    return $res;
  }

  /**
   * Checks if user and password matches or not.
   * @param Sql_result $res
   *  Sql_resut from database.
   * @param  String $user
   *  User who is logged in.
   * @param  string $pass
   *  Password of the user..
   * @return mixed
   *  Redirects the user based on his entered details.
   */
  public function checkuser($res, $user, $pass)
  {
    while ($temp = mysqli_fetch_array ($res)) {
      if ($temp['username'] == $user && $temp['password'] == $pass) {
        $_SESSION['username'] = $temp['username'];
        header('location: /index.php?controller=User&function=myblogs');
        break;
      }
    }
    echo '<div class="alert alert-danger" role="alert">Wrong Username or password</div>';
    include ('view/loginView.php');
  }
}

?>
