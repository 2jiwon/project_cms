<?php 
include ('includes/db.php'); 
include ('includes/header.php'); 
include ('includes/main_functions.php');
?>
    <!-- Navigation -->
<?php 
include ('includes/navigation.php'); 
?>

<?php

if (isset($_POST['like'])) {
  $post_id = $_POST['post_id'];

  // selecting the liked post 
  $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
  $result = mysqli_query ($connection, $query);
  $postResult = mysqli_fetch_array ($result);
  $likes = $postResult['post_likes'];

  // updating post_likes
  $query = "UPDATE posts SET post_likes = {$likes} + 1 WHERE post_id = {$post_id} ";
  $result = mysqli_query ($connection, $query);

}

?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
<?php

if (isset ($_GET['p_id'])) {
  $post_id = preg_replace('#[^0-9]#', '', $_GET['p_id']);

  $query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = ? ";
  $stmt = $connection->prepare ($query);
  $stmt->bind_param ("i", $post_id);
  $stmt->execute ();
  $stmt->close ();

  // Check the User's access authority
  if (is_admin ($_SESSION['username'])) {
    $query      = "SELECT * FROM posts WHERE post_id = {$post_id} ";
    $query_prev = "SELECT post_id FROM posts WHERE post_id < '{$post_id}' ORDER BY post_id DESC LIMIT 1 ";
    $query_next = "SELECT post_id FROM posts WHERE post_id > '{$post_id}' ORDER BY post_id ASC LIMIT 1 ";
  } else {
    $query      = "SELECT * FROM posts WHERE post_id = {$post_id} AND post_status = 'Published' ";
    $query_prev = "SELECT post_id FROM posts WHERE post_id < '{$post_id}' AND post_status = 'Published' ORDER BY post_id DESC LIMIT 1 ";
    $query_next = "SELECT post_id FROM posts WHERE post_id > '{$post_id}' AND post_status = 'Published' ORDER BY post_id ASC LIMIT 1 ";
  } 

  $select_all_posts_query = mysqli_query ($connection, $query);
  
  if (mysqli_num_rows ($select_all_posts_query) > 0) {

    while ($row = mysqli_fetch_assoc ($select_all_posts_query)) {
      $post_title   = $row['post_title'];
      $post_author  = $row['post_author'];
      $post_date    = $row['post_date'];
      $post_image   = $row['post_image'];
      $post_content = $row['post_content'];
?>
                <!-- First Blog Post -->
                <div class="custom-panel">
                  <h3>
                    <?php echo $post_title ?></a>
                  </h3>
                </div>
                <p class="lead">
                  by <?php echo $post_author ?></a>
                </p>
                <p>
                  <span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?>
                </p>
                <hr>

                  <img class="img-responsive" src="<?php echo $home_url ?>/images/<?php echo $post_image ?>" alt="">

                <p>
                  <?php echo $post_content ?>
                </p>

<!-- Edit post button -->
<?php
      if (is_admin ($_SESSION['username'])) {
        $post_id =  preg_replace ('#[^0-9]#', '', $_GET['p_id']);
        if (isset ($post_id)) {
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

<!-- Likes button -->
<div class="row">
  <p class="pull-left col-md-2"><a id="like" href="#"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a></p>
<!-- Likes status -->
  <p class="left col-md-2">Likes: 10</a></p>
</div>








<?php
    } // End of first while
?>

                <!-- Blog Comments -->
<?php
    if (isset ($_POST['create_comment'])) {
      $post_id = preg_replace('#[^0-9]#', '', $_GET['p_id']);
      $comment_author  = $_POST['comment_author'];
      $comment_email   = $_POST['comment_email'];
      $comment_content = $_POST['comment_content'];

      $query  = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_date) ";
      $query .= "VALUES ( ?, ?, ?, ?, NOW()) ";
      
      $stmt = $connection->prepare ($query);
      $stmt->bind_param ("isss", $post_id, $comment_author, $comment_email, $comment_content);
      $stmt->execute ();
      $stmt->close ();
    }
?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">

                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input class="form-control" type="text" name="comment_author" required>
                    </div>

                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input class="form-control" type="email" name="comment_email" required>
                    </div>

                        <div class="form-group">
                            <label for="Comment">Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3" required></textarea>
                        </div>
                        <button class="btn btn-primary" name="create_comment" type="submit">Submit</button>

                    </form>
                </div>

                <!-- Posted Comments -->
<?php

      $query  = "SELECT * FROM comments WHERE comment_post_id = ? ";
      $query .= "AND comment_status = 'Approved' ";
      $query .= "ORDER BY comment_id DESC ";

      $stmt = $connection->prepare ($query);
      $stmt->bind_param ("i", $post_id);
      $stmt->execute ();
      $result = $stmt->get_result ();

      while ($row = $result->fetch_assoc ()) {
        $comment_author  = $row['comment_author'];
        $comment_email   = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status  = $row['comment_status'];
        $comment_date    = $row['comment_date'];
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
<?php
post_pager ($query_prev, $prev_id, 'previous', '&larr; Older');
post_pager ($query_next, $next_id, 'next',     'Newer &rarr;');
?>
                <!-- End of Pager -->
<?php
  } else {
    echo "  <h1 class='page-header'>
                  No Posts Available 
                  <small></small>
            </h1>";
  }
} else { // End of the first if
  header ("Location: ../index.php");
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

        <!-- Footer -->
<?php
include ('includes/footer.php');
?>

<!-- For like -->
<script>
$(document).ready(function () {
  var url = '<?php echo $home_url; ?>/post/<?php echo $post_id; ?>';
  var post_id = '<?php echo $post_id; ?>';
  var user_id = 36;

  $('#like').click(function () {
    $.ajax({
      url: url,
      type: 'post',
      data: {
        'like': 1,
        'post_id': encodeURI(post_id),
        'user_id': user_id

      }
    });
  });
});
</script>
