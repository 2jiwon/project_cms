<?php

if (isset ($_GET['p_id'])) {
  $post_id = $_GET['p_id'];
}

  $query = "SELECT * FROM posts WHERE post_id={$post_id}";
  $select_all_posts = mysqli_query ($connection, $query);

  confirm_query ($select_all_posts); 

  while ($row = mysqli_fetch_assoc ($select_all_posts)) {
    $the_post_category_id = $row['post_category_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];

    $post_image = $row['post_image'];

    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comments = $row['post_comment_count'];
    $post_status = $row['post_status'];
  }
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-inline form-group">
    <label for="post_id">Post Id</label>
    <div>
      <div class="form-control" name="post_id">
        <?php echo $post_id; ?>
      </div>
    </div>
  </div>

  <div class="form-inline form-group">
    <label for="post_category">Post Category</label>
    <div>
      <select class="form-control" name="post_category_id" id="post_category">
<?php

  $query = "SELECT * FROM categories"; 
  $select_categories_query = mysqli_query ($connection, $query);

  confirm_query ($select_categories_query);

  while ($row = mysqli_fetch_assoc ($select_categories_query)) {
      $post_category_id = $row['cat_id'];
      $post_category    = $row['cat_title'];  

    if ($the_post_category_id === $post_category_id) {
      echo "<option value='{$post_category_id}' selected>{$post_category}</option>";
    } else {
      echo "<option value='{$post_category_id}'>{$post_category}</option>";
    }
   }
?>  
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="title">Post Title</label>
      <input class="form-control" name="post_title" type="text" value="<?php echo $post_title; ?>">
  </div>

  <div class="form-group">
    <label for="post_author">Post author</label>
      <input class="form-control" name="post_author" type="text" value="<?php echo $post_author; ?>">
  </div>

  <div class="form-group">
    <label for="post_date">Post Date</label>
      <div><?php echo $post_date; ?></div>
      <input class="form-control" name="post_date" type="datetime-local">
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
      <div>
        <img src="../images/<?php echo $post_image; ?>" width="100" alt="image">
      </div>
      <input class="form-control" name="post_image" type="file">
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
      <textarea class="form-control" name="post_content" id="" cols="30" rows="10">
<?php echo $post_content; ?>
      </textarea>
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
      <input class="form-control" name="post_tags" type="text" value="<?php echo $post_tags; ?>">
  </div>

  <div class="form-group">
    <label for="post_status">Post Status</label>
      <input class="form-control" name="post_status" type="text" value="<?php echo $post_status; ?>" readonly>
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="update_post" value="Edit Post" type="submit">
  </div>

</form>

<?php
  if (isset ($_POST['update_post'])) {
  
  $post_category_id = $_POST['post_category_id'];
  $post_title = $_POST['post_title'];
  $post_author = $_POST['post_author'];
  //$post_date = date ('Y-m-d H:i:s');

  $post_image = $_FILES['post_image']['name'];
  $post_image_temp = $_FILES['post_image']['tmp_name'];
  move_uploaded_file ($post_image_temp, "../images/{$post_image}");

  $post_content = $_POST['post_content'];
  $post_content = mysqli_real_escape_string ($connection, $post_content);
  $post_tags = $_POST['post_tags'];
  $post_status = $_POST['post_status'];
  $post_comment_count = 4;

  if (empty ($post_image)) {
    $query = "SELECT post_image FROM posts WHERE post_id ={$post_id} ";
    $select_image = mysqli_query ($connection, $query);

    while ($row = mysqli_fetch_assoc ($select_image)) {
      $post_image = $row['post_image'];
    }
  }

  $query  = "UPDATE posts SET "; 
  $query .= "post_category_id = '{$post_category_id}', ";
  $query .= "post_title = '{$post_title}', ";
  $query .= "post_author = '{$post_author}', ";
  $query .= "post_date = NOW(), ";
  $query .= "post_image = '{$post_image}', ";
  $query .= "post_content = '{$post_content}', ";
  $query .= "post_tags = '{$post_tags}', ";
  $query .= "post_status = '{$post_status}' ";
  $query .= "WHERE post_id={$post_id}";

  $update_post = mysqli_query ($connection, $query);

  confirm_query ($update_post);
  header ("Location: posts.php");
  }
  
?>
