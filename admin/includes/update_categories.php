                          <form action="" method="post">
                            <div class="form-group">
                              <label for="cat-title">Edit Category</label>
<?php

// Get the cat_id for edit value.
if (isset ($_GET['edit'])) {  //<-- this is not from a form but from a table
  $cat_id = $_GET['edit'];

  global $connection;

  $query = "SELECT * FROM categories WHERE cat_id = {$cat_id} ";
  $select_categories_id = mysqli_query ($connection, $query);

  while ($row = mysqli_fetch_assoc ($select_categories_id)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
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

  $query = "UPDATE categories SET cat_title = '{$cat_title_for_edit}' WHERE cat_id = {$cat_id} ";
  $update_query = mysqli_query ($connection, $query);

  if (!$update_query) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
}
?>
                              </div>
                              <div class="form-group">
                                <input class="btn btn-primary" name="edit" type="submit" value="Edit">
                            </div>
                          </form>
