<?php

if (isset ($_GET['p_id'])) {
  $post_id = $_GET['p_id'];
}

  $query = "SELECT * FROM posts WHERE post_id={$post_id}";
  $select_all_posts = mysqli_query ($connection, $query);

  confirm_query ($select_all_posts); 

  while ($row = mysqli_fetch_assoc ($select_all_posts)) {
    $post_category_id = $row['post_category_id'];
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

  <div class="form-group">
    <label for="post_id">Post Id</label>
      <div class="well well-sm" name="post_id">
        <?php echo $post_id; ?>
      </div>
  </div>

  <div class="form-group">
    <label for="post_category">Post Category</label>
    <div>
      <select name="post_category" id="post_category">
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
      <input class="form-control" name="post_status" type="text" value="<?php echo $post_status; ?>">
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="create_post" value="Publish Post" type="submit">
  </div>

</form>
