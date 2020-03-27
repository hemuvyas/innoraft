<!-- Form to add the blog data -->
<div class="container" style="border: 1px solid black;">
  <br>
  <form action="/mvc/index.php?controller=User&function=home"  method="post" enctype="multipart/form-data">
    <input  type="text" name="Title"  required placeholder="Enter Title of the Post"> <br>
    <textarea name="Des" rows="8" cols="121" required placeholder="Enter Description of the post"></textarea>
    <br><br>
    <input type="file" name="pic"   value="Select Image"><br>
    <input  type="submit"  class="form-control" value="Submit">
  </form>

</div>
