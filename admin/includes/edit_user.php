<?php

if (isset ($_GET['u_id'])) {
  $user_id = $_GET['u_id'];
}

  $query = "SELECT * FROM users WHERE user_id={$user_id}";
  $select_all_users = mysqli_query ($connection, $query);

  confirm_query ($select_all_users); 

  while ($row = mysqli_fetch_assoc ($select_all_users)) {
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];
  }
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-inline form-group">
    <label for="user_id">User Id</label>
      <input class="form-control" name="user_id" type="text" value="<?php echo $user_id; ?>" readonly>
  </div>

  <div class="form-group">
    <label for="user_name">Username</label>
      <input class="form-control" name="user_name" type="text" value="<?php echo $user_name; ?>">
  </div>

  <div class="form-group">
    <label for="user_password">User Password</label>
      <input class="form-control" name="user_password" type="password" value="<?php echo $user_password; ?>">
  </div>

  <div class="form-group">
    <label for="user_firstname">User Firstname</label>
      <input class="form-control" name="user_firstname" type="text" value="<?php echo $user_firstname; ?>">
  </div>

  <div class="form-group">
    <label for="user_lastname">User Lastname</label>
      <input class="form-control" name="user_lastname" type="text" value="<?php echo $user_lastname; ?>">
  </div>

  <div class="form-group">
    <label for="user_email">User Email</label>
      <input class="form-control" name="user_email" type="email" value="<?php echo $user_email; ?>">
  </div>

  <div class="form-group">
    <label for="user_image">User Image</label>
      <div>
        <img src="../images/<?php echo $user_image; ?>" width="100" alt="image">
      </div>
      <input class="form-control" name="user_image" type="file">
  </div>

  <div class="form-inline form-group">
    <label for="user_category">User Role</label>
    <div>
      <select class="form-control" name="user_role" id="user_role">
      <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
        <option value="Admin">Admin</option>
        <option value="Subscriber">Subscriber</option>
      </select>
    </div>
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="update_user" value="Edit User" type="submit">
  </div>

</form>

<?php
  if (isset ($_POST['update_user'])) {
  
  $user_name = $_POST['user_name'];
  $user_password = $_POST['user_password'];
  $user_firstname = $_POST['user_firstname'];

  $user_image = $_FILES['user_image']['name'];
  $user_image_temp = $_FILES['user_image']['tmp_name'];
  move_uploaded_file ($user_image_temp, "../images/{$user_image}");

  $user_lastname = $_POST['user_lastname'];
  $user_email  = $_POST['user_email'];
  $user_email  = mysqli_real_escape_string ($connection, $user_email);
  $user_status = $_POST['user_status'];
  $user_comment_count = 4;

  if (empty ($user_image)) {
    $query = "SELECT user_image FROM users WHERE user_id ={$user_id} ";
    $select_image = mysqli_query ($connection, $query);

    while ($row = mysqli_fetch_assoc ($select_image)) {
      $user_image = $row['user_image'];
    }
  }

  $query  = "UPDATE users SET "; 
  $query .= "user_id = '{$user_id}', ";
  $query .= "user_name = '{$user_name}', ";
  $query .= "user_password = '{$user_password}', ";
  $query .= "user_firstname = '{$user_firstname}', ";
  $query .= "user_lastname = '{$user_lastname}', ";
  $query .= "user_email = '{$user_email}', ";
  $query .= "user_image = '{$user_image}', ";
  $query .= "user_role = '{$user_role}' ";
  $query .= "WHERE user_id={$user_id}";

  $update_User = mysqli_query ($connection, $query);

  confirm_query ($update_User);
  header ("Location: users.php");
  }

?>
