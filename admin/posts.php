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
    echo "</tr>";
  };
}

?>
<!--
    <td>1</td>
    <td>Jiwon</td>
    <td>Bootstrap</td>
    <td>CSS</td>
    <td>draft</td>
    <td>some.jpg</td>
    <td>CSS</td>
    <td>something</td>
    <td>2018.03.31</td>
-->
</tbody>
</table>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
<?php
include "includes/admin_footer.php";
?>
