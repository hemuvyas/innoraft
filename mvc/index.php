<style>
  *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  .container{
    width: 90%;
    margin: 20px auto;
    box-shadow:0px 3px 7px #1a1a1a;
    padding: 10px;
  }
  .container h5{
    margin-top: 10px;
  }
</style>
<?php
$controller = 'home';
$function = 'home';
if (isset ($_GET['controller']) && $_GET['controller'] != '') {
  $controller = $_GET['controller'];
}
if (isset ($_GET['function']) && $_GET['function'] != '') {
  $function = $_GET['function'];
}
session_start ();
include ('view/header.php');
include ('controllers/'.$controller.'Controller.php');
$class = $controller.'Controller';
$obj = new $class;
$obj -> $function ();
?>
