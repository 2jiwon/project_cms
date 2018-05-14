<?php

if (isset ($_POST['checkBoxArray'])) {
  
  foreach ($_POST['checkBoxArray'] as $checkboxValue) {
    $bulk_options = $_POST['bulk_options']; 

    switch ($bulk_options) {
      case 'publish':
        $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = {$checkboxValue} ";
        break;
      case 'draft'  :
        $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = {$checkboxValue} ";
        break;
      case 'clone'  :
        $select_query = "SELECT * FROM posts WHERE post_id = {$checkboxValue} ";
        $select_post_query = mysqli_query ($connection, $select_query);

        while ($row = mysqli_fetch_assoc ($select_post_query)) {
          $post_category_id = $row['post_category_id'];
          $post_title       = $row['post_title'];
          $post_author      = $row['post_author'];
          $post_date        = $row['post_date'];
          $post_image       = $row['post_image'];
          $post_tags        = $row['post_tags'];
          $post_comments    = $row['post_comment_count'];
          $post_view_count  = $row['post_view_count'];
          $post_status      = $row['post_status'];
        }

        $query  = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, ";
        $query .= "post_tags, post_comment_count, post_view_count, post_status) ";
        $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', NOW(), '{$post_image}', ";
        $query .= "'{$post_tags}', '{$post_comments}', '{$post_view_count}', '{$post_status}') ";
        break;

      case 'delete' :
        $query = "DELETE FROM posts WHERE post_id = {$checkboxValue} ";
        break;
      }

     $update_query = mysqli_query ($connection, $query);
      confirm_query ($update_query);
  }
}

?>
<form action="" method="post">  

<table class="table table-bordered table-hover">

      <div class="row form-inline">
        <div id="bulkOptionsContainer" class="col-md-6">
          <div class="input-group">
            <select class="form-control" id="" name="bulk_options">
              <option value="">Select Options</option>
              <option value="draft">Draft</option>
              <option value="publish">Publish</option>
              <option disabled>--------------</option>
              <option value="clone">Clone</option>
              <option value="delete">Delete</option>
            </select>
            <div class="input-group-btn">
              <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>
          </div>

          <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
        </div>
      </div>
      <p></p>

  <thead>
    <tr>
      <th><input type="checkbox" name="" id="selectAllBoxes"></th>
      <th>Id</th>
      <th>Category</th>
      <th>Title</th>
      <th>Author</th>
      <th>Date</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Views</th>
      <th>Status</th>
      <th>Publish</th>
      <th>Draft</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
    </tr>
  </thead>
<tbody>

<?php

$query = "SELECT * FROM posts";
$select_all_posts = mysqli_query ($connection, $query);

if (!$select_all_posts) {
  die ("QUERY FAILED" . mysqli_error ($connection));
} else {

  while ($row = mysqli_fetch_assoc ($select_all_posts)) {
    $post_id          = $row['post_id'];
    $post_category_id = $row['post_category_id'];
    $post_title       = $row['post_title'];
    $post_author      = $row['post_author'];
    $post_date        = $row['post_date'];
    $post_image       = $row['post_image'];
    $post_tags        = $row['post_tags'];
    $post_comments    = $row['post_comment_count'];
    $post_view_count  = $row['post_view_count'];
    $post_status      = $row['post_status'];

    echo "<tr>";
?>
  <td><input class="checkboxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>

<?php
    echo "<td>{$post_id}</td>";

    $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
    $select_categories_id = mysqli_query ($connection, $query);

    while ($row = mysqli_fetch_assoc ($select_categories_id)) {
      $post_category_id = $row['cat_title'];
    }

    echo "<td>{$post_category_id}</td>";
    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
    echo "<td>{$post_author}</td>";
    echo "<td>{$post_date}</td>";
    echo "<td><img class='img-responsive' width='100' src='../images/{$post_image}' alt='{$post_image}'></td>";
    echo "<td>{$post_tags}</td>";
    echo "<td>{$post_comments}</td>";
    echo "<td>{$post_view_count}</td>";
    echo "<td>{$post_status}</td>";
    echo "<td><a href='posts.php?publish={$post_id}'>Publish</a></td>";
    echo "<td><a href='posts.php?draft={$post_id}'>Draft</a></td>";
    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
    echo "<td><a data-toggle='modal' data-target='#delete{$post_id}'>Delete</a></td>";
    echo "</tr>";
    
    echo "  <!-- Modal for delete -->";
    echo "  <div id='delete{$post_id}' class='modal fade' tabindex='-1' role='dialog'>";
    echo "    <div class='modal-dialog' role='document'>";
    echo "      <div class='modal-content'>";
    echo "        <div class='modal-header'>";
    echo "          <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
    echo "          <h4 class='modal-title'>Delete Post</h4>";
    echo "        </div>";
    echo "        <div class='modal-body'>";
    echo "          <h2>{$post_id}</h2>";
    echo "          <p>Are you sure to delete this post?</p>";
    echo "        </div>";
    echo "        <div class='modal-footer'>";
    echo "          <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>";
    echo "          <a type='button' class='btn btn-primary' href='posts.php?delete={$post_id}'>Delete</a>";
    echo "        </div>";
    echo "      </div><!-- /.modal-content -->";
    echo "    </div><!-- /.modal-dialog -->";
    echo "  </div><!-- /.modal -->";
  }
}
?>

</tbody>
</table>
</form>
<?php

if (isset ($_GET['publish'])) {
  $post_id_for_publish = $_GET['publish'];

  $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = {$post_id_for_publish} ";
  $publish_query = mysqli_query ($connection, $query);

  confirm_query ($publish_query);
  header ("Location: posts.php");
}

if (isset ($_GET['draft'])) {
  $post_id_for_draft = $_GET['draft'];

  $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = {$post_id_for_draft} ";
  $draft_query = mysqli_query ($connection, $query);

  confirm_query ($draft_query);
  header ("Location: posts.php");
}

if (isset ($_GET['delete'])) {
  $post_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM posts WHERE post_id = {$post_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);

  confirm_query ($delete_query);
  header ("Location: posts.php");
}
?>
