<?php
include "includes/header.php";
?>
    <div id="wrapper">

        <!-- Navigation -->
<?php
include "includes/navigation.php";
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
                            <tr>
                              <td>First Category</td>
                              <td>Second Category</td>
                            </tr>
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
include "includes/footer.php";
?>
