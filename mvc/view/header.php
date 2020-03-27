<!-- Header file of MVC blog -->

<!DOCTYPE html>
<html>
<head>
</head>
<body>

  <ul>
    <li><a href="/mvc/index.php">Home</a></li>
    <?php
    if(isset($_SESSION['username'])){
      echo '<li><a href="/mvc/index.php?controller=User&function=myblogs" style="text-transform:capitalize;">'.$_SESSION['username'].'\'s blogs</a></li>';
      echo '<li><a href="/mvc/index.php?controller=User&funtion=add">Add New Blog</a></li>';
      echo '<li><a href="/mvc/index.php?controller=Login&function=logout">Log Out</a></li>';
    }
    else{
      echo '<li><a href="/mvc/index.php?controller=Login&function=login">Log In</a></li>';
    }
    ?>
  </ul>

</body>
</html>




