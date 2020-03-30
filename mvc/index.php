<?php

/**
 * @file
 * provides routing for the mvc blog application.
 */


$controller = 'Home';
$function = 'home';

// Getting the values of controller from url.
if (isset($_GET['controller']) && $_GET['controller'] != '') {
  $controller = $_GET['controller'];
}

// Getting the values of function from url.
if (isset($_GET['function']) && $_GET['function'] != '') {
  $function = $_GET['function'];
}
session_start();

// Including header for mvc project.
include('view/header.php');

// Including the required controller and functions file, if not exist then shown error.
if (file_exists('controllers/' . $controller . 'Controller.php')) {
  include('controllers/' . $controller . 'Controller.php');
  $class = $controller . 'Controller';
  $obj = new $class();
  if (method_exists($obj, $function)) {
    $obj->$function();
  }
  else {
    include('view/error.php');
  }
}
else {
  include('view/error.php');
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="public/css/style.css">
  <title></title>
</head>
</html>

