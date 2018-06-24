                          <form action="" method="post">
                            <div class="form-group">
                              <label for="cat-title">Edit Category</label>
<?php

// Get the cat_id for edit value.
if (isset ($_GET['edit'])) {  //<-- this is not from a form but from a table
  $cat_id = $_GET['edit'];

  global $connection;

  $statement = mysqli_prepare ($connection, 
    "SELECT cat_id, cat_title FROM categories WHERE cat_id = ? ");

  mysqli_stmt_bind_param ($statement, "i", $cat_id);
  mysqli_stmt_execute ($statement);
  mysqli_stmt_bind_result ($statement, $cat_id, $cat_title);

  while (mysqli_stmt_fetch ($statement)) { 
?>
                            <input class="form-control" name="cat_title" 
                                   value="<?php 
                                               if (isset ($cat_title)) {
                                                  echo $cat_title;
                                               }
                                          ?>"
                                   type="text">
<?php 
  }
}
?>
<?php

// Make query to update the category title
if (isset ($_POST['edit'])) {
  $cat_title_for_edit = $_POST['cat_title'];

  $statement = mysqli_prepare ($connection, 
    "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
  
  mysqli_stmt_bind_param ($statement, "si", $cat_title_for_edit, $cat_id);
  mysqli_stmt_execute ($statement);

  if (!$statement) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
}
?>
                              </div>
                              <div class="form-group">
                                <input class="btn btn-primary" name="edit" type="submit" value="Edit">
                            </div>
                          </form>
