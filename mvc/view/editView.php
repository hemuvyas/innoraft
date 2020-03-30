<?php

/**
 * @file
 * Form for editing the data by it's author.
 */

$temp = mysqli_fetch_array($res1);
?>
<div class="container">
  <br>
  <form class="form-group" action="/index.php?controller=User&function=edit&id=<?php echo $temp['id']; ?>" method="post" enctype="multipart/form-data">
    <input <?php echo 'value="'.$temp['Title'].'"'; ?> class="form-control" type="text" name="Title"  required placeholder="Enter Title of the Post"> <br>
    <textarea name="Des" rows="8" cols="121" required placeholder="Enter Description of the post"><?php echo $temp['Des'];  ?></textarea>
    <br><br>
    <?php echo $temp['image'];  ?>
    <input type="file" name="pic" class="form-control"  value="Select Image"><br>
    <input class="btn btn-primary" type="submit"  class="form-control" value="Save Changes">
  </form>

</div>
