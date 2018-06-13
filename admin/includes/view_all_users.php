<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>User Image</th>
      <th>User Role</th>
      <th>User Status</th>
      <th>Approve</th>
      <th>Disapprove</th>
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
    $user_firstname = $row['user_firstname'];
    $user_lastname  = $row['user_lastname'];
    $user_image     = $row['user_image'];
    $user_role      = $row['user_role'];
    $user_email     = $row['user_email'];
    $user_status    = $row['user_status'];

    echo "<tr>";
    echo "<td>{$user_id}</td>";
    echo "<td>{$user_name}</td>";
    echo "<td>{$user_firstname}</td>";
    echo "<td>{$user_lastname}</td>";
    echo "<td>{$user_email}</td>";
    echo "<td><img class='img-responsive' width='100' src='../images/{$user_image}' alt='{$user_image}'></td>";
    echo "<td>{$user_role}</td>";
    echo "<td>{$user_status}</td>";
    echo "<td><a href='users.php?approve={$user_id}'>Approve</a></td>";
    echo "<td><a href='users.php?disapprove={$user_id}'>Disapproved</a></td>";
    echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
    echo "<td><a data-toggle='modal' data-target='#delete{$user_id}'>Delete</a></td>";

    echo "   <!-- Modal for delete -->";
    echo "  <div id='delete{$user_id}' class='modal fade' tabindex='-1' role='dialog'>";
    echo "    <div class='modal-dialog' role='document'>";
    echo "      <div class='modal-content'>";
    echo "        <div class='modal-header'>";
    echo "          <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
    echo "          <h4 class='modal-title'>Delete User</h4>";
    echo "        </div>";
    echo "        <div class='modal-body'>";
    echo "          <h2>{$user_id}</h2>";
    echo "          <p>Are you sure to delete this user?</p>";
    echo "        </div>";
    echo "        <div class='modal-footer'>";
    echo "          <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>";
    echo "          <a type='button' class='btn btn-primary' href='users.php?delete={$user_id}'>Delete</a>";
    echo "        </div>";
    echo "      </div><!-- /.modal-content -->";
    echo "    </div><!-- /.modal-dialog -->";
    echo "  </div><!-- /.modal -->";
    echo "</tr>";
  }
}
?>
</tbody>
</table>

<?php

if (isset ($_GET['approve'])) {
  $user_id_for_approve = mysqli_real_escape_string ($connection, $_GET['approve']);

  $query = "UPDATE users SET user_status = 'Approved' WHERE user_id = {$user_id_for_approve} ";
  $approve_query = mysqli_query ($connection, $query);

  confirm_query ($approve_query);
  header ("Location: users.php");
}

if (isset ($_GET['disapprove'])) {
  $user_id_for_disapprove = mysqli_real_escape_string ($connection, $_GET['disapprove']);

  $query = "UPDATE users SET user_status = 'Unapproved' WHERE user_id = {$user_id_for_disapprove} ";
  $disapprove_query = mysqli_query ($connection, $query);

  confirm_query ($disapprove_query);
  header ("Location: users.php");
}

if (isset ($_GET['delete'])) {
  $user_id_for_delete = mysqli_real_escape_string ($connection, $_GET['delete']);
  $query = "DELETE FROM users WHERE user_id = {$user_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);

  confirm_query ($delete_query);
  header ("Location: users.php");
}
?>

