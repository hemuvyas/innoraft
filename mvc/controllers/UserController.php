<?php

/**
 * @file
 * It contains the controller file for authenticated users and their functionality like EDIT, ADD or DELETE a blog
 */

// If user is not logged in then send him to homepage.
if (!isset($_SESSION['username'])) {
  header('location: /mvc/index.php');
}

class UserController {
 // function home () {
 //   echo $_SESSION['username'];
 //   add();
 // }

 // Function to display the blogs authored by them only.
 function myblogs() {
   include('model/userblogModel.php');
   include('view/userblogView.php');
 }

 // Function to add the blog by a author.
 function home() {

   // If title is not null then enter the data in database.
   // Else reopen the enter blog data form.
   if (isset($_POST['Title'])) {
     $title = $_POST['Title'];
     $des = $_POST['Des'];
     $time = time();
     $username = $_SESSION['username'];
     echo $_SESSION['username'];
     $img = $_FILES['pic']['name'];

     //stores the temp name of image
     $tmp_img = $_FILES['pic']['tmp_name'];

     //locate the image in the folder
     $img_locate = "pic/" . $img;
     move_uploaded_file($tmp_img,$img_locate);
     include('model/addModel.php');

     // If added successfully then redirect to index page.
     if ($res) {
       header('location:/mvc/index.php');
     }
   }
   else {
    include('view/addView.php');
  }
}

// Function to delete the blog by specific id.
function delete () {
  $id = $_GET['id'];
  include('model/deleteModel.php');
  header('location: /mvc/');
}

// Function to edit the blog defined by user.
function edit() {
 // If title is not null then edit the data in database
 // Else reopen the edit blog data form.
 if (isset($_POST['Title'])) {
   $title = $_POST['Title'];
   $des = $_POST['Des'];
   $time = time();
   $username = $_SESSION['username'];
   echo $_SESSION['username'];
   if ($_FILES['pic']) {

     $img = $_FILES['pic']['name'];
     // Stores the temp name of image.
     $tmp_img = $_FILES['pic']['tmp_name'];
     // Locate the image in the folder
     $img_locate = "pic/" . $img;
     move_uploaded_file($tmp_img,$img_locate);
   }
   include('model/addModel.php');

   // If edited successfully then redirect to index page.
   if ($res) {
     header('location:/mvc/');
   }
 }
 include('model/blogModel.php');
 include('view/editView.php');
}

}

?>
