<?php

if (isset ($_POST['create_post'])) {
  
  $post_category_id = $_POST['post_category_id'];
  $post_title = $_POST['post_title'];
  $post_author = $_POST['post_author'];
  $post_date = date ('Y-m-d H:i:s');

  $post_image = $_FILES['post_image']['name'];
  $post_image_temp = $_FILES['post_image']['tmp_name'];

  $post_content = $_POST['post_content'];
  $post_tags = $_POST['post_tags'];
  $post_status = $_POST['post_status'];
  $post_comment_count = 4;

  move_uploaded_file ($post_image_temp, "../images/{$post_image}");

  $query  = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
  $query .= "VALUES ('{$post_category_id}', '{$post_title}', '{$post_author}', NOW(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}') ";

  $create_post_query = mysqli_query ($connection, $query);

  confirm_query ($create_post_query); 
}
  
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-inline form-group">
    <label for="post_category_id">Post Category Id</label>
    <div>
      <select class="form-control" name="post_category_id" id="post_category">
<?php
  $query = "SELECT * FROM categories"; 
  $select_categories_id = mysqli_query ($connection, $query);

  confirm_query ($select_categories_id);

  while ($row = mysqli_fetch_assoc ($select_categories_id)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<option value='{$cat_title}'>{$cat_title}</option>";
  }
?>  
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="title">Post Title</label>
      <input class="form-control" name="post_title" type="text">
  </div>

  <div class="form-group">
    <label for="post_author">Post author</label>
      <input class="form-control" name="post_author" type="text">
  </div>

  <div class="form-group">
    <label for="post_date">Post Date</label>
      <input class="form-control" name="post_date" type="datetime-local">
  </div>

  <div class="form-group">
    <label for="post_image">Post Image</label>
      <input class="form-control" name="post_image" type="file">
  </div>

  <div class="form-group">
    <label for="post_content">Post Content</label>
      <textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
  </div>

  <div class="form-group">
    <label for="post_tags">Post Tags</label>
      <input class="form-control" name="post_tags" type="text">
  </div>

  <div class="form-group">
    <label for="post_status">Post Status</label>
      <input class="form-control" name="post_status" type="text">
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="create_post" value="Publish Post" type="submit">
  </div>

</form>
