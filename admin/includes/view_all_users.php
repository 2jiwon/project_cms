<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Password</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>User Image</th>
      <th>User Role</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
    </tr>
  </thead>
<tbody>

<?php

$query = "SELECT * FROM users";
$select_all_users = mysqli_query ($connection, $query);

if (!$select_all_users) {
  die ("QUERY FAILED" . mysqli_error ($connection));
} else {

  while ($row = mysqli_fetch_assoc ($select_all_users)) {
    $user_id        = $row['user_id'];
    $user_name      = $row['user_name'];
    $user_password  = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname  = $row['user_lastname'];
    $user_image     = $row['user_image'];
    $user_role      = $row['user_role'];
    $user_email     = $row['user_email'];

    echo "<tr>";
    echo "<td>{$user_id}</td>";
    echo "<td>{$user_name}</td>";
    echo "<td>{$user_password}</td>";
    echo "<td>{$user_firstname}</td>";
    echo "<td>{$user_lastname}</td>";
    echo "<td><img class='img-responsive' width='100' src='../images/{$user_image}' alt='{$user_image}'></td>";
    echo "<td>{$user_role}</td>";
    echo "<td>{$user_email}</td>";
    echo "<td><a href='users.php?approve={$user_id}'>Approve</a></td>";
    echo "<td><a href='users.php?unapprove={$user_id}'>Unapprove</a></td>";
    echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
    echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
    echo "</tr>";
  };
}
?>
</tbody>
</table>

<?php

/*
if (isset ($_GET['approve'])) {
  $user_id_for_approve = $_GET['approve'];

  $query = "UPDATE users SET user_status = 'approved' WHERE user_id = {$user_id_for_approve} ";
  $approve_query = mysqli_query ($connection, $query);

  confirm_query ($approve_query);
  header ("Location: users.php");
}

if (isset ($_GET['draft'])) {
  $post_id_for_draft = $_GET['draft'];

  $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = {$post_id_for_draft} ";
  $draft_query = mysqli_query ($connection, $query);

  confirm_query ($draft_query);
  header ("Location: posts.php");
}
 */

if (isset ($_GET['delete'])) {
  $user_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM users WHERE user_id = {$user_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);

  confirm_query ($delete_query);
  header ("Location: users.php");
}

?>

