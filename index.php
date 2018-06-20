<?php 
include ('includes/db.php'); 
include ('includes/header.php'); 
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
// Count total posts and set the variables for pagination 
if (isset ($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
  $query  = "SELECT * FROM posts ";
} else {
  $query  = "SELECT * FROM posts WHERE post_status = 'Published' ";
} 
$total_posts_query = mysqli_query ($connection, $query);
$total_posts = mysqli_num_rows ($total_posts_query);

// How many posts to display for each page
$per_page = 5;
// last_page means total pages;
$last_page = ceil ($total_posts / $per_page);
// How many numbers to display for a set of pagination
$pageset = 5;

if (isset ($_GET['page'])) {
  $pagenum = preg_replace('#[^0-9]#', '', $_GET['page']);
} else {
  $pagenum = 1;
}

if ($pagenum < 1) {
  $pagenum = 1;
} else if ($pagenum > $last_page) {
  $pagenum = $last_page;
}

$limit = 'LIMIT '.($pagenum - 1) * $per_page .','.$per_page;

?>

<?php
// post display
// if user is not 'Admin', don't display draft posts.
if (isset ($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
  $query  = "SELECT * FROM posts ";
} else {
  $query  = "SELECT * FROM posts WHERE post_status = 'Published' ";
} 
$query .= "ORDER BY post_id DESC {$limit} ";
$select_all_posts_query = mysqli_query ($connection, $query);

if (mysqli_num_rows ($select_all_posts_query) > 0) {

  while ($row = mysqli_fetch_assoc ($select_all_posts_query)) {
    $post_id      = $row['post_id'];
    $post_title   = $row['post_title'];
    $post_author  = $row['post_author'];
    $post_date    = $row['post_date'];
    $post_image   = $row['post_image'];
    $post_content = substr ($row['post_content'], 0, 100);
?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                  <?php echo $post_id; ?><a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>">
                    <?php echo $post_author ?></a>
                </p>
                <p>
                  <span class="glyphicon glyphicon-time"></span><?php echo $post_date ?>
                </p>

                <hr>
                  <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
<?php
  } // End of while
// End of post display
?>
                <!-- Pager -->
                <nav aria-label="Page navigation" class="col-md-6 col-md-offset-3">
                  <ul class="pagination">
<?php
if ($last_page != 1) {

  if ($pagenum > 1) {
    $prev_page = $pagenum - 1;

    echo "<li class='page-item'>
            <a class='page-link' href='index.php?page={$prev_page}' aria-label='Previous'>
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
              <a href='index.php?page={$i}'>{$i}</a>
            </li>";
    }
  }

    echo "<li class='active'>
            <a href='index.php?page={$pagenum}'>{$pagenum}<span class='sr-only'>(current)</span></a>
          </li>";

  for ($i = $pagenum + 1; $i <= ($pagenum + $pageset - 1); $i++) {
    if ($pagenum % $pageset == 0 || $i > $last_page) {
       break;
    }
      echo "<li>
              <a href='index.php?page={$i}'>{$i}</a>
            </li>";

    if ($i % $pageset == 0) {
      break;
    }
  }

  if ($pagenum != $last_page) {
    $next_page = $pagenum + 1;
    echo "<li class='page-item'>
            <a class='page-link' href='index.php?page={$next_page}' aria-label='Next'>
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
<?php
} else {
    echo "  <h1 class='page-header'>
                  No Posts Available 
                  <small></small>
            </h1>";
}
?>
            <!-- End of Blog Entries Column -->
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
