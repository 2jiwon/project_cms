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

                    </div>
                </div>
                <!-- /.row -->

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Response To</th>
      <th>Author</th>
      <th>Email</th>
      <th>comments</th>
      <th>Status</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Disapprove</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
    </tr>
  </thead>
<tbody>

<?php

if (isset ($_GET['c_id'])) {
  $c_id = mysqli_real_escape_string ($connection, $_GET['c_id']);
}

$query = "SELECT * FROM comments WHERE comment_post_id = {$c_id} ";
$select_all_comments = mysqli_query ($connection, $query);

  if (!$select_all_comments) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }

  while ($row = mysqli_fetch_assoc ($select_all_comments)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_email = $row['comment_email'];
    $comment_content = $row['comment_content'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];
   }

    echo "<tr>";
    echo "<td>{$comment_id}</td>";

    $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
    $comment_post = mysqli_query ($connection, $query);

    while ($row = mysqli_fetch_assoc ($comment_post)) {
      $post_id     = $row['post_id'];
      $response_to = $row['post_title'];
    }

    echo "<td><a href='../post.php?p_id={$post_id}'>{$response_to}</a></td>";
    echo "<td>{$comment_author}</td>";
    echo "<td>{$comment_email}</td>";
    echo "<td>{$comment_content}</td>";
    echo "<td>{$comment_status}</td>";
    echo "<td>{$comment_date}</td>";

    echo "<td><a href='post_comments.php?approve={$comment_id}&c_id={$c_id}'>Approve</a></td>";
    echo "<td><a href='comments.php?disapprove={$comment_id}&c_id={$c_id}'>Disapprove</a></td>";
    echo "<td><a href='comments.php?source=edit_comment&p_id={$comment_id}'>Edit</a></td>";
    echo "<td><a data-toggle='modal' data-target='#delete{$comment_id}'>Delete</a></td>";
    echo "</tr>";

    echo "  <!-- Modal for delete -->";
    ECHo "  <div id='delete{$comment_id}' class='modal fade' tabindex='-1' role='dialog'>";
    echo "    <div class='modal-dialog' role='document'>";
    echo "      <div class='modal-content'>";
    echo "        <div class='modal-header'>";
    echo "          <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
    echo "          <h4 class='modal-title'>Delete Comment</h4>";
    echo "        </div>";
    echo "        <div class='modal-body'>";
    echo "          <p>Are you sure to delete this comment?</p>";
    echo "        </div>";
    echo "        <div class='modal-footer'>";
    echo "          <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>";
    echo "          <a type='button' class='btn btn-primary' href='post_comments.php?delete={$comment_id}&c_id={$c_id}'>Delete</a>";
    echo "        </div>";
    echo "      </div><!-- /.modal-content -->";
    echo "    </div><!-- /.modal-dialog -->";
    echo "  </div><!-- /.modal -->";

?>
</tbody>
</table>

<?php

if (isset ($_GET['approve'])) {
  $comment_id_for_approve = $_GET['approve'];

  $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$comment_id_for_approve} ";
  $approve_query = mysqli_query ($connection, $query);

  confirm_query ($approve_query);
  header ("Location: post_comments.php?c_id={$_GET['c_id']}");
}

if (isset ($_GET['disapprove'])) {
  $comment_id_for_disapprove = $_GET['disapprove'];

  $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$comment_id_for_disapprove} ";
  $disapprove_query = mysqli_query ($connection, $query);

  confirm_query ($disapprove_query);
  header ("Location: post_comments.php?c_id={$_GET['c_id']}");
}

if (isset ($_GET['delete'])) {
  $comment_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM comments WHERE comment_id = {$comment_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);
  confirm_query ($delete_query);
  header ("Location: post_comments.php?c_id={$_GET['c_id']}");

  //$query  = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
  //$query .= "WHERE post_id = {$post_id} ";
  //$minus_comment_count = mysqli_query ($connection, $query);
  //confirm_query ($minus_comment_count);
}
?>

            </div>
            <!-- /.container-fluid -->
        </div>

<?php
include "includes/admin_footer.php";
?>
