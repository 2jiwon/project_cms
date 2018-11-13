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

if (isset ($_POST['submit'])) {
  $search = $_POST['search'];

  $query  = "SELECT * FROM posts WHERE post_content LIKE ? ";
  $stmt   = $connection->prepare ($query);
  $search = "%".$search."%";

  $stmt->bind_param ("s", $search);
  $stmt->execute ();
  
  $result = $stmt->get_result ();
  $count  = $result->num_rows;

  if ($count == 0) {
    echo "<h1> NO RESULT </h1>";
  } else {

    while ($row = $result->fetch_assoc ()) {
      $post_id      = $row['post_id'];
      $post_title   = $row['post_title'];
      $post_author  = $row['post_author'];
      $post_date    = $row['post_date'];
      $post_image   = $row['post_image'];
      $post_content = $row['post_content'];
?>
                <!-- First Blog Post -->
                <h1>
                  <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h1>
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
     }
  }
}
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

<?php
include ('includes/footer.php');
?>
