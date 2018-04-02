<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Category</th>
      <th>Title</th>
      <th>Author</th>
      <th>Date</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Status</th>
      <th>Delete</th>
    </tr>
  </thead>
<tbody>

<?php

$query = "SELECT * FROM posts";
$select_all_posts = mysqli_query ($connection, $query);

if (!$select_all_posts) {
  die ("QUERY FAILED" . mysqli_error ($connection));
} else {

  while ($row = mysqli_fetch_assoc ($select_all_posts)) {
    $post_id = $row['post_id'];
    $post_category_id = $row['post_category_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comments = $row['post_comment_count'];
    $post_status = $row['post_status'];

    echo "<tr>";
    echo "<td>{$post_id}</td>";
    echo "<td>{$post_category_id}</td>";
    echo "<td>{$post_title}</td>";
    echo "<td>{$post_author}</td>";
    echo "<td>{$post_date}</td>";
    echo "<td><img class='img-responsive' width='100' src='../images/{$post_image}' alt='{$post_image}'></td>";
    echo "<td>{$post_tags}</td>";
    echo "<td>{$post_comments}</td>";
    echo "<td>{$post_status}</td>";
    echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
    echo "</tr>";
  };
}
?>
</tbody>
</table>

<?php

if (isset ($_GET['delete'])) {
  $post_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM posts WHERE post_id = {$post_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);

  confirm_query ($delete_query);
  header ("Location: posts.php");
}

?>




