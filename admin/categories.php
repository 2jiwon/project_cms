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
                          <form action="">
                            <div class="form-group">
                              <label for="cat-title">Add Category</label>
                                <input class="form-control" name="cat_title" type="text">
                            </div>
                            <div class="form-group">
                              <input class="btn btn-primary" name="submit" type="submit">
                            </div>
                          </form>
                        </div>

                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Categoty Title</th>
                            </tr>
                          </thead>
                          <tbody>
<?php

$query = "SELECT * FROM categories";
$select_all_categories = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_all_categories)) {
  $cat_id = $row['cat_id'];
  $cat_title = $row['cat_title'];
    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "</tr>";
}
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
