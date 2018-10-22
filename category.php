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

  $total_posts = mysqli_stmt_num_rows ($stmt);

// Page related values
  // How many posts to display for each page
  $per_page = 5;
  // last_page means total pages;
  $last_page = ceil ($total_posts / $per_page);
  // How many numbers to display for a set of pagination
  $pageset = 5;

  if (isset ($_GET['page'])) {
    //$pagenum = preg_replace('#[^0-9]#', '', $_GET['page']);
    $pagenum = $_GET['page'];
  } else {
    $pagenum = 1;
  }

  if ($pagenum < 1) {
    $pagenum = 1;
  } else if ($pagenum > $last_page) {
    $pagenum = $last_page;
  }

  $start = ($pagenum - 1) * $per_page;

  if ($total_posts > 0) {
    while (mysqli_stmt_fetch ($stmt)) {
?>

                <!-- First Blog Post -->
                <h2>
                  <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                  <p class="lead">
                  by <a href="post/<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                  </p>
                  <p class="text-right"><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <a href="post/<?php echo $post_id; ?>"><img class="img-responsive" src="<?php echo $home_url ?>images/<?php echo $post_image ?>" alt=""></a>
                <hr>
                <p><?php echo substr ($post_content, 0, 100) . " ..."; ?></p>
                <a class="btn btn-primary" href="post/<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
<?php
    } // End of while
?>

                <!-- Pager -->
                <nav aria-label="Page navigation" class="col-md-6 col-md-offset-3">
                  <ul class="pagination">
<?php
  if ($last_page != 1) {

    if ($pagenum > 1) {
      $prev_page = $pagenum - 1;

      echo "<li class='page-item'>
            <a class='page-link' href='category/{$post_category_id}/page/{$prev_page}' aria-label='Previous'>
              <span aria-hidden='true'>&laquo;</span>
              <span class='sr-only'>Previous</span>
            </a>";
    } else {
      echo "<li class='page-item disabled'>
            <span aria-hidden='true'>&laquo;</span>";
    }
      echo "</li>";

    $startnum = (floor($pagenum / $pageset) * $pageset) + 1;
  
    if ($pagenum < $startnum) {
      $startnum = (floor (($pagenum - 1) / $pageset) * $pageset) + 1;
    }

    for ($i = $startnum; $i < $pagenum; $i++) {
      if ($i > 0 && $i >= $startnum) {
        echo "<li>
              <a href='category/{$post_category_id}/page/{$i}'>{$i}</a>
              </li>";
      }
    }

    echo "<li class='active'>
            <a href='category/{$post_category_id}/page/{$pagenum}'>{$pagenum}<span class='sr-only'>(current)</span></a>
          </li>";

    for ($i = $pagenum + 1; $i <= ($pagenum + $pageset - 1); $i++) {
      if ($pagenum % $pageset == 0 || $i > $last_page) {
         break;
      }
      echo "<li>
              <a href='category/{$post_category_id}/page/{$i}'>{$i}</a>
            </li>";

      if ($i % $pageset == 0) {
        break;
      }
    } 

    if ($pagenum != $last_page) {
      $next_page = $pagenum + 1;
      echo "<li class='page-item'>
              <a class='page-link' href='category/{$post_category_id}/page/{$next_page}' aria-label='Next'>
              <span aria-hidden='true'>&raquo;</span>
              <span class='sr-only'>Next</span>
              </a>";
    } else {
      echo "<li class='page-item disabled'>
              <span aria-hidden='true'>&raquo;</span>";
    }
    echo "</li>";
  }
?>
                  </ul>
                </nav>
                <!-- End of Pager -->
<?php
  } else {
    echo "  <h1 class='page-header'>
                  No Posts Available 
                  <small></small>
            </h1>";
  }

  mysqli_stmt_close ($stmt);
} // End of first if
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
