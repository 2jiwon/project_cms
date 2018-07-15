<?php

if (isset ($_POST['create_post'])) {
  
  $post_category_id = $_POST['post_category_id'];
  $post_title       = $_POST['post_title'];
  $post_author      = $_POST['post_author'];
  $post_date        = date ('Y-m-d H:i:s', strtotime ($_POST['post_date']));

  $post_image       = $_FILES['post_image']['name'];
  $post_image_temp  = $_FILES['post_image']['tmp_name'];
  move_uploaded_file ($post_image_temp, "../images/{$post_image}");

  if (empty ($post_image)) {
    $post_image = '';
  }

  $post_content     = $_POST['post_content'];
  $post_content     = mysqli_real_escape_string ($connection, $post_content);
  $post_tags        = $_POST['post_tags'];
  $post_status      = $_POST['post_status'];

  $query  = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
  $query .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ? ) ";
  
  $stmt   = $connection->prepare ($query);
  $stmt->bind_param ("isssssss", $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags, $post_status);
  $stmt->execute ();

  echo "<div class='alert alert-success'>
          Post successfully created.
            <a href='posts.php' class='alert-link'>
               View Post Table
            </a>
        </div>";

} else {

  if (isset ($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT user_name FROM users WHERE user_name = ? ";
    $stmt  = $connection->prepare ($query);
    $stmt->bind_param ("s", $username);
    $stmt->execute ();
    
    $result = $stmt->get_result ();
    $row    = $result->fetch_assoc ();
    $post_author = $row['user_name'];
  
  } else {
    die ("<div class='alert alert-danger'>Something's wrong. You may need to log in again.</div>");
  }
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-inline form-group">
    <label for="post_category_id">Post Category</label>
    <div>
      <select class="form-control" name="post_category_id" id="post_category">
<?php

  $query = "SELECT cat_id, cat_title FROM categories ";
  $stmt  = $connection->prepare ($query);
  $stmt->execute ();
  
  $result = $stmt->get_result ();

  while ($row = $result->fetch_assoc ()) {
    $post_category_id = $row['cat_id'];
    $cat_title        = $row['cat_title'];

    echo "<option value='{$post_category_id}'>{$cat_title}</option>";
  }
?>  
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="title">Post Title</label>
      <input class="form-control" name="post_title" type="text" required>
  </div>

  <div class="form-group">
    <label for="post_author">Post author</label>
    <input class="form-control" name="post_author" type="text" value="<?php echo $post_author; ?>" readonly>
  </div>

  <div class="form-inline form-group">
      <label for="post_date">Post Date</label>
      <div>
        <div class="input-group date" id="datetimepicker">
          <input type="text" class="form-control" name="post_date" id="post_date" value="" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
      </div>
  </div>
  <script src="js/jquery.js"></script>
  <script type="text/javascript">
    $(function () {
      $('#datetimepicker').datetimepicker({
        showClear: true
      });
    });
  </script>

  <div class="form-group">
    <label for="post_image">Post Image</label>
      <input class="form-control" name="post_image" type="file">
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
      <textarea class="form-control" name="post_content" id="editor" cols="30" rows="10"></textarea>
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
      <input class="form-control" name="post_tags" type="text">
  </div>

  <div class="form-inline form-group">
    <label for="post_status">Post Status</label>
      <div>
        <select class="form-control" name="post_status" id="">
          <option value="">Select Option</option>
          <option value="Published">Publish</option>
          <option value="Draft">Draft</option>
        </select>
      </div>
  </div>

  <hr>

  <div class="form-group">
      <input class="btn btn-primary" name="create_post" value="Create Post" type="submit">
  </div>

</form>
<?php
}
?>
