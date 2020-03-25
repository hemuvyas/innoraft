 <!--  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> -->
  <!--  <a class="navbar-brand" href="/">Home</a> -->
  <!--  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> -->

  <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto"> -->
      <!DOCTYPE html>
      <html>
      <head>
        <style>
          ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333333;
          }

          li {
            float: left;
          }

          li a {
            display: block;
            color: white;
            text-align: center;
            padding: 16px;
            text-decoration: none;
          }

          li a:hover {
            background-color: #111111;
          }
        </style>
      </head>
      <body>

        <ul>
          <li><a href="/mvc/index.php">Home</a></li>
          <?php
          if(isset($_SESSION['username'])){
            echo '<li><a href="/mvc/index.php?controller=user&function=myblogs" style="text-transform:capitalize;">'.$_SESSION['username'].'\'s blogs</a></li>';
            echo '<li><a href="/mvc/index.php?controller=user&funtion=add">Add New Blog</a></li>';
            echo '<li><a href="/mvc/index.php?controller=login&function=logout">Log Out</a></li>';
          }
          else{
            echo '<li><a href="/mvc/index.php?controller=login&function=login">Log In</a></li>';
          }
          ?>
        </ul>

      </body>
      </html>





      <?php
          // if(isset($_SESSION['username'])){

          //   echo '<li class="nav-item active">
          //   <a class="nav-link" href="/index/user/myblogs" style="text-transform:capitalize;">'.$_SESSION['username'].'\'s blogs</a>
          //   </li>';

          //   echo '<li class="nav-item active">
          //   <a class="nav-link" href="/index/user/add">Add New Blog</a>
          //   </li>';


          //   echo '<li class="nav-item active">
          //   <a class="nav-link" href="/index/login/logout">Log Out</a>
          //   </li>';



          // }

          // else {

          //   echo '<li class="nav-item active">
          //   <a class="nav-link" href="/index/login/login">Log In <span class="sr-only">(current)</span></a>
          //   </li>';
          // }


      ?>
<!--
        </ul>
      </div>
    </nav>
 -->
