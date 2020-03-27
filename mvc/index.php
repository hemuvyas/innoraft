<?php

/**
 * @file
 * provides routing for the mvc blog application.
 */

// Setting the default values for controller and function if not provided.
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

// Including the required controller file.
include('controllers/' . $controller . 'Controller.php');
$class = $controller . 'Controller';
$obj = new $class();
$obj->$function();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="public/css/style.css">
  <title></title>
</head>
</html>

