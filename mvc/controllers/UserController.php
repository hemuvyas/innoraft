<?php

/**
 * @file
 * It contains the controller file for authenticated users and their functionality like EDIT, ADD or DELETE a blog
 */

/**
 * Class for controller which handles all the authenticated user, and if not then redirect to homepage.
 */
class UserController {

  /**
   * Whenever the object is cretaed it checks if user authenticated or not.
   */
  function __construct()
  {
    if (!isset($_SESSION['username'])) {
      header('location: /index.php');
    }
  }


 //
 /**
  * Function to display the blogs authored by them only.
  * @return mixed
  *  Displays all blogs for the logged in user.
  */
  function myblogs() {
   include('model/userblogModel.php');
   $model = new UserBlogModel();
   $res = $model->BlogData();
   include('view/userblogView.php');
   $view = new UserBlogView();
   $view->DisplayId($res);
 }

 //
 /**
  * Function to add the blog by a author.
  */
 function add() {

   // If user enters the data then enter data in database.
   if (isset($_POST['Title'])) {
     $time = time();
     $user = $_SESSION['username'];
     $img = $_FILES['pic']['name'];
     $tmp_img = $_FILES['pic']['tmp_name'];
     $img_locate = "pic/" . $img;
     move_uploaded_file($tmp_img,$img_locate);
     include('model/userblogModel.php');
     $model = new UserBlogModel();
     $res = $model->AddData($_POST['Title'], $_POST['Des'], $img_locate, $time, $user);

     // If added successfully then redirect to index page.
     if ($res) {
       header('location:/index.php');
     }
   }
   else {
    include('view/addView.php');
  }
}

/**
 * Function to delete the blog by specific id.
 * @return mixed
 *  Deletes the blog from the database.
 */
function delete () {
  $id = $_GET['id'];
  include('model/userblogModel.php');
  $model = new UserBlogModel();
  $model->DeleteData($id);
  header('location: /');
}

/**
 * Function to edit the blog defined by user.
 * @return mixed
 *  Edits the blog in the database.
 */
function edit() {

 // If title is not null then edit the data in database
 // Else reopen the edit blog data form.
 if (isset($_POST['Title'])) {
   $time = time();
   $id = $_GET['id'];
   echo $id;
   if ($_FILES['pic']) {
     $img = $_FILES['pic']['name'];
     // Stores the temp name of image.
     $tmp_img = $_FILES['pic']['tmp_name'];
     // Locate the image in the folder
     $img_locate = "pic/" . $img;
     move_uploaded_file($tmp_img,$img_locate);
   }
   include('model/userblogModel.php');
   $model = new UserBlogModel();
   $res = $model->EditData($_POST['Title'], $_POST['Des'], $img_locate, $time, $id);
   // If edited successfully then redirect to index page.
   if ($res) {
     header('location:/');
   }
 }
 include('model/blogModel.php');
 $model = new BlogModel();
 $res1 = $model->BlogForId($_GET['id']);
 include('view/editView.php');
}

}

?>
