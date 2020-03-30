<!-- Contains the login form code to be shown to users. -->
<div class="mx-auto my-5" style="width:50%;padding:50px;box-shadow:0px 3px 7px #1a1a1a; margin:0 auto;">
    <form class="login form-group" action="/index.php?controller=Login&function=validate" method="post">
    <input class="form-control" type="text" name="username" placeholder="Enter your username"><br>
    <input class="form-control" type="password" name="password" placeholder="Enter your password"><br>
    <input class="form-control btn btn-primary" type="submit" value="login">
  </form>
</div>
