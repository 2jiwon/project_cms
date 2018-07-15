<?php

if (isset ($_POST['checkBoxArray'])) {
  
  foreach ($_POST['checkBoxArray'] as $checkboxValue) {
    $bulk_options = $_POST['bulk_options']; 

    switch ($bulk_options) {
      case 'approve':
        $query = "UPDATE users SET user_status = 'Approved' WHERE user_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'disapprove':
        $query = "UPDATE users SET user_status = 'Unapproved' WHERE user_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'clone':
        $query = "SELECT * FROM users WHERE user_id = ? ";
        $stmt = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        $stmt->execute ();
        
        $result = $stmt->get_result ();

        while ($row = $result->fetch_assoc ()) {
          $user_name        = $row['user_name'];
          $user_firstname   = $row['user_firstname'];
          $user_lastname    = $row['user_lastname'];
          $user_password    = $row['user_password'];
          $user_email       = $row['user_email'];
          $user_image       = $row['user_image'];
          $user_role        = $row['user_role'];
          $user_status      = $row['user_status'];
        }

        $query  = "INSERT INTO users (user_name, user_firstname, user_lastname, user_password, ";
        $query .= "user_email, user_image, user_role, user_status) ";
        $query .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )";
        $stmt   = $connection->prepare ($query);
        $stmt->bind_param ("ssssssss", $user_name, $user_firstname, $user_lastname, $user_password, $user_email, $user_image, $user_role, $user_status);
        break;

      case 'delete':
        $query = "DELETE FROM users WHERE user_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'reset':
        $query = "UPDATE users SET user_password = '' WHERE user_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;
    }

    $stmt->execute ();
    header ("Location: users.php");
  }
}

?>

<form action="" method="post">  
  <table class="table table-bordered table-hover">

      <div class="row form-inline">
        <div id="bulkOptionsContainer" class="col-md-6">
          <div class="input-group">
            <select class="form-control" id="" name="bulk_options">
              <option value="">Select Options</option>
              <option value="approve">Approve</option>
              <option value="disapprove">Disapprove</option>
              <option disabled>--------------</option>
              <option value="reset">Reset</option>
              <option value="clone">Clone</option>
              <option value="delete">Delete</option>
            </select>
            <div class="input-group-btn">
              <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>
          </div>

          <a class="btn btn-primary" href="users.php?source=add_user">Add New User</a>
        </div>
      </div>
      <p></p>

    <thead>
      <tr>
        <th><input type="checkbox" name="" id="selectAllBoxes"></th>
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
confirm_query ($select_all_users);

  while ($row = mysqli_fetch_assoc ($select_all_users)) {
    $user_id        = $row['user_id'];
    $user_name      = $row['user_name'];
    $user_firstname = $row['user_firstname'];
    $user_lastname  = $row['user_lastname'];
    $user_image     = $row['user_image'];
    $user_role      = $row['user_role'];
    $user_email     = $row['user_email'];
    $user_status    = $row['user_status'];

    echo "<tr>
          <td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='{$user_id}'></td>
    <td>{$user_id}</td>
    <td>{$user_name}</td>
    <td>{$user_firstname}</td>
    <td>{$user_lastname}</td>
    <td>{$user_email}</td>
    <td><img class='img-responsive' width='100' src='../images/{$user_image}' alt='{$user_image}'></td>
    <td>{$user_role}</td>
    <td>{$user_status}</td>
    <td><a href='users.php?approve={$user_id}'>Approve</a></td>
    <td><a href='users.php?disapprove={$user_id}'>Disapproved</a></td>
    <td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>
    <td><a data-toggle='modal' data-target='#delete{$user_id}'>Delete</a></td>";

    delete_modal ($user_id, 'user', 'users.php');
  }
?>
  </tbody>
  </table>
</form>

<?php

if (isset ($_GET['approve'])) {
  $user_id_for_approve = $_GET['approve'];

  $query = "UPDATE users SET user_status = 'Approved' WHERE user_id = ? ";
  $stmt  = $connection->prepare ($query);
  $stmt->bind_param ("i", $user_id_for_approve);
  $stmt->execute ();
  header ("Location: users.php");
}

if (isset ($_GET['disapprove'])) {
  $user_id_for_disapprove = mysqli_real_escape_string ($connection, $_GET['disapprove']);

  $query = "UPDATE users SET user_status = 'Unapproved' WHERE user_id = ? ";
  $stmt  = $connection->prepare ($query);
  $stmt->bind_param ("i", $user_id_for_disapprove);
  $stmt->execute ();
  header ("Location: users.php");
}

if (isset ($_POST['delete'])) {
  $user_id_for_delete = mysqli_real_escape_string ($connection, $_POST['id']);

  $query = "DELETE FROM users WHERE user_id = ? ";
  $stmt  = $connection->prepare ($query);
  $stmt->bind_param ("i", $user_id_for_delete);
  $stmt->execute ();
  header ("Location: users.php");
}
?>
