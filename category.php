<?php 
include ('includes/db.php'); 
include ('includes/header.php'); 
include ('includes/main_functions.php');
?>
    <!-- Navigation -->
<?php 
include ('includes/navigation.php'); 
?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
<?php

if (isset ($_GET['category'])) {
  $post_category_id = $_GET['category'];
  $published = 'Published';

  if (is_admin ($_SESSION['username'])) {
    $query  = "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ORDER BY post_id DESC ";
    $stmt1  = mysqli_prepare ($connection, $query);

  } else {
    $query  = "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ORDER BY post_id DESC ";
    $stmt2  = mysqli_prepare ($connection, $query);
  } 

  if (isset ($stmt1)) {
    mysqli_stmt_bind_param ($stmt1, "i", $post_category_id);
    mysqli_stmt_execute ($stmt1);
    mysqli_stmt_store_result ($stmt1);
    mysqli_stmt_bind_result ($stmt1, $post_id,
                                     $post_title,
                                     $post_author,
                                     $post_date,
                                     $post_image,
                                     $post_content);
    $stmt = $stmt1;

  } else {
    mysqli_stmt_bind_param ($stmt2, "is", $post_category_id, $published);
    mysqli_stmt_execute ($stmt2);
    mysqli_stmt_store_result ($stmt2);
    mysqli_stmt_bind_result ($stmt2, $post_id,
                                     $post_title,
                                     $post_author,
                                     $post_date,
                                     $post_image,
                                     $post_content);
    $stmt = $stmt2;
  }

  if (mysqli_stmt_num_rows ($stmt) > 0) {
    while (mysqli_stmt_fetch ($stmt)) {
?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                  <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content . " ..."; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
<?php
    } // End of while
?>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>
<?php
  } else {
    echo "  <h1 class='page-header'>
                  No Posts Available 
                  <small></small>
            </h1>";
  }
} // End of fist if
?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
<?php 
include ('includes/sidebar.php'); 
?>
            </div>
        </div>
        <!-- /.row -->
        <hr>

        <!-- Footer -->
<?php
include ('includes/footer.php');
?>
