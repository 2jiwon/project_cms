<?php
include "includes/admin_header.php";
?>
    <div id="wrapper">

        <!-- Navigation -->
<?php
include "includes/admin_navigation.php";
?>

        <div id="page-wrapper">
          <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
              <div class="col-xs-12 col-sm-12 table-responsive">

                <h1 class="page-header">
                  Welcome to Admin
                  <small>Author</small>
                </h1>
<?php
insert_categories ();
?>
                <div class="col-md-6">
                <form action="" method="post">
                  <div class="form-group">
                    <label for="cat-title">Add Category</label>
                      <input class="form-control" name="cat_title" type="text">
                  </div>
                  <div class="form-group">
                    <input class="btn btn-primary" name="submit" type="submit" value="Add">
                  </div>
                </form>
<?php
update_categories ();
?>
                <!-- end col-xs-6 -->
                </div>

                <div class="col-md-6">
<?php
// for bulkoptions
if (isset ($_POST['checkBoxArray'])) {
  
  foreach ($_POST['checkBoxArray'] as $checkboxValue) {
    $bulk_options = $_POST['bulk_options']; 

    switch ($bulk_options) {
      case 'clone'  :
        $select_query = "SELECT * FROM categories WHERE cat_id = {$checkboxValue} ";
        $select_category = mysqli_query ($connection, $select_query);

        while ($row = mysqli_fetch_assoc ($select_category)) {
          $cat_title = $row['cat_title'];
        }
        $query  = "INSERT INTO categories (cat_title) ";
        $query .= "VALUES ('{$cat_title}') ";
        break;

      case 'delete' :
        $query = "DELETE FROM categories WHERE cat_id = {$checkboxValue} ";
        break;
    }
    
    $bulk_query = mysqli_query ($connection, $query);
    confirm_query ($bulk_query);
    header ("Location: categories.php");
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
                          <option value="clone">Clone</option>
                          <option value="delete">Delete</option>
                        </select>
                        <div class="input-group-btn">
                          <input type="submit" name="submit" class="btn btn-success" value="Apply">
                        </div>
                      </div>
                    </div>
                  </div>
                  <p></p>

                  <thead>
                    <tr>
                      <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                      <th>ID</th>
                      <th>Categoty Title</th>
                      <th>Delete</th>
                      <th>Edit</th>
                    </tr>
                  </thead>
                  <tbody>
<?php

display_categories ();
delete_categories ();

?>
                  </tbody>
                </table>
               </form> 
               </div>

              </div> 
            </div>
            <!-- /.row -->

          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php
include "includes/admin_footer.php";
?>
