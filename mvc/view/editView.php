<?php
$temp = mysqli_fetch_array($res);  ?>
<div class="container">
  <br>
  <form class="form-group" action="/mvc/index.php?controller=user&function=edit"  method="post" enctype="multipart/form-data">
    <input <?php echo 'value="'.$temp['Title'].'"'; ?> class="form-control" type="text" name="Title"  required placeholder="Enter Title of the Post"> <br>
    <textarea name="Des" rows="8" cols="121" required placeholder="Enter Description of the post"><?php echo $temp['Des'];  ?></textarea>
    <br><br>
    <?php echo $temp['image'];  ?>
    <input type="file" name="pic" class="form-control"  value="Select Image"><br>
    <input class="btn btn-primary" type="submit"  class="form-control" value="Save Changes">
  </form>

</div>
