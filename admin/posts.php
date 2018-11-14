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

if (isset ($_GET['source'])) {
  $source = mysqli_real_escape_string ($connection, $_GET['source']);
} else {
  $source = '';
}

//permission_warning ();

  switch ($source) {
    case 'add_post':
      include "includes/add_post.php";
    break;

    case 'edit_post':
      include "includes/edit_post.php";
    break;

    default:
      include "includes/view_all_posts.php";
    break;
  }
?>
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
