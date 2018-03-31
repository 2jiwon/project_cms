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
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        <div class="col-xs-6">
<?php
insert_categories ();
?>
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

                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Categoty Title</th>
                              <th>Delete</th>
                              <th>Edit</th>
                            </tr>
                          </thead>
                          <tbody>
<?php
// Find all categories query
find_all_categories ();
?>
<?php
delete_categories ();
?>
                          </tbody>
                        </table>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
<?php
include "includes/admin_footer.php";
?>
