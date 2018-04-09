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
      <th>Unapprove</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
    </tr>
  </thead>
<tbody>

<?php

$query = "SELECT * FROM comments";
$select_all_comments = mysqli_query ($connection, $query);

if (!$select_all_comments) {
  die ("QUERY FAILED" . mysqli_error ($connection));
} else {

  while ($row = mysqli_fetch_assoc ($select_all_comments)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_email = $row['comment_email'];
    $comment_content = $row['comment_content'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];

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

    echo "<td><a href='posts.php?source=edit_post&p_id={$comment_post_id}'>Approve</a></td>";
    echo "<td><a href='posts.php?delete={$comment_post_id}'>Unapprove</a></td>";
    echo "<td><a href='comments.php?source=edit_comment&p_id={$comment_id}'>Edit</a></td>";
    echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
    echo "</tr>";
  };
}
?>
</tbody>
</table>

<?php

if (isset ($_GET['delete'])) {
  $comment_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM comments WHERE comment_id = {$comment_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);

  confirm_query ($delete_query);
  header ("Location: comments.php");
}

?>
