<?php 
include ('includes/db.php'); 
include ('includes/header.php'); 
include ('admin/functions.php');
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

if (isset ($_GET['p_id'])) {
  $post_id = $_GET['p_id'];
}

$query  = "SELECT * FROM posts WHERE post_id = {$post_id} ";
$select_all_posts_query = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_all_posts_query)) {
  $post_title   = $row['post_title'];
  $post_author  = $row['post_author'];
  $post_date    = $row['post_date'];
  $post_image   = $row['post_image'];
  $post_content = $row['post_content'];
?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                <a href=""><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

<!-- Edit post button -->
<?php

  if (isset ($_SESSION['user_role'])) {
    if (isset ($_GET['p_id'])) {
      echo "    <div class='row'>
                   <div class='col-md-offset-10 col-xs-2'>
                      <a href='admin/posts.php?source=edit_post&p_id={$post_id}'>
                        <button class='btn btn-default' name='edit_post' type='submit'>
                          Edit Post
                        </button>
                      </a>
                  </div>
                </div>";
    }
  }
?>
                <hr>
<?php
}
?>

<?php
if (isset ($_POST['create_comment'])) {
  $post_id = $_GET['p_id'];
  $comment_author  = $_POST['comment_author'];
  $comment_email   = $_POST['comment_email'];
  $comment_content = $_POST['comment_content'];

  $query  = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_date) ";
  $query .= "VALUES ('{$post_id}', '{$comment_author}', '{$comment_email}', '{$comment_content}', NOW()) ";

  $create_comment = mysqli_query ($connection, $query);
  confirm_query ($create_comment);

  $query  = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
  $query .= "WHERE post_id = $post_id ";
  $update_comment_count = mysqli_query ($connection, $query);
  confirm_query ($update_comment_count);
}

?>
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">

                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input class="form-control" type="text" name="comment_author">
                    </div>

                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input class="form-control" type="email" name="comment_email">
                    </div>

                        <div class="form-group">
                            <label for="Comment">Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary" name="create_comment" type="submit">Submit</button>

                    </form>
                </div>
                <hr>

                <!-- Posted Comments -->
<?php

$query  = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
$query .= "AND comment_status = 'Approved' ";
$query .= "ORDER BY comment_id DESC ";

$show_comments = mysqli_query ($connection, $query);
confirm_query ($show_comments);

while ($row = mysqli_fetch_assoc ($show_comments)) {
  $comment_author = $row['comment_author'];
  $comment_email = $row['comment_email'];
  $comment_content = $row['comment_content'];
  $comment_status = $row['comment_status'];
  $comment_date = $row['comment_date'];
?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                    <h4 class="media-heading">
                      <a href="mailto:<?php echo $comment_email; ?>"><?php echo $comment_author; ?></a>
                        <small><?php echo $comment_date; ?></small>
                    </h4><?php echo $comment_content; ?>
                    </div>
                </div>
<?php
}
?>
              <hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

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

