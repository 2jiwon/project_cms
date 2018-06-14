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

if (isset ($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}

$per_page = 5;
$page_limit = 5;

if ($page == "" || $page == 1) {
  $page_start = 0;
} else {
  $page_start = ($page * $per_page) - $per_page;
}

$query  = "SELECT * FROM posts WHERE post_status = 'Published' ";
$posts_count_query = mysqli_query ($connection, $query);
$posts_count = mysqli_num_rows ($posts_count_query);
$posts_count = ceil ($posts_count / 5);
#$total_pages = ceil ($posts_count / $per_page);

$query  = "SELECT * FROM posts WHERE post_status = 'Published' ";
$query .= "ORDER BY post_id DESC LIMIT {$page_start}, {$per_page} ";
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
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>

                <!-- Pager -->
                <nav aria-label="Page navigation" class="col-md-6 col-md-offset-3">
                  <ul class="pagination">
<?php

  if ($page > 1) {
    $prev_page = $page - 1;
    echo "<li class='page-item'>";
  } else {
    echo "<li class='page-item disabled'>";
  }
    echo "<a class='page-link' href='index.php?page={$prev_page}' aria-label='Previous'>";
    echo "  <span aria-hidden='true'>&laquo;</span>";
    echo "  <span class='sr-only'>Previous</span>";
    echo "</a>";
    echo "</li>";

for ($i = 1; $i <= $posts_count; $i++) {
  if ($i == $page) {
    echo "<li class='active'>";
    echo "    <a href='index.php?page={$i}'>{$i}<span class='sr-only'>(current)</span></a>";
    echo "</li>";
  } else {
    echo "<li>";
    echo "    <a href='index.php?page={$i}'>{$i}</a>";
    echo "</li>";
  }
}
  if ($page > 1 && $page < $posts_count) {
    $next_page = $page + 1;
    echo "<li class='page-item'>";
  } else {
    echo "<li class='page-item disabled'>";
  }
    echo "<a class='page-link' href='index.php?page={$next_page}' aria-label='Next'>";
    echo "  <span aria-hidden='true'>&raquo;</span>";
    echo "  <span class='sr-only'>Next</span>";
    echo "</a>";
    echo "</li>";
?>
                  </ul>
                </nav>
<?php
  }
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
