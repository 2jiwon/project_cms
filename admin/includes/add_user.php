<?php

if (isset ($_POST['create_user'])) {
  
  $user_name       = $_POST['user_name'];
  $user_password   = $_POST['user_password'];
  $confirm_user_password   = $_POST['confirm_user_password'];
  
  if ($user_password !== $confirm_user_password) {
    die ("Please recheck your password.");
  }

  $user_firstname  = $_POST['user_firstname'];
  $user_lastname   = $_POST['user_lastname'];
  $user_email      = $_POST['user_email'];
  $user_role       = $_POST['user_role'];

  $user_image      = $_FILES['user_image']['name'];
  $user_image_temp = $_FILES['user_image']['tmp_name'];
  move_uploaded_file ($user_image_temp, "../images/{$user_image}");

  if (empty ($user_image)) {
    $user_image = '';
  }

#  $post_content = mysqli_real_escape_string ($connection, $post_content);

  $query  = "INSERT INTO users (user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
  $query .= "VALUES ('{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}') ";

  $create_user_query = mysqli_query ($connection, $query);
  confirm_query ($create_user_query);
  header ("Location: users.php");
}
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-group">
    <label for="user_name">Username</label>
      <input class="form-control" name="user_name" type="text" required>
  </div>

  <div class="form-group">
    <label for="user_password">Password</label>
      <input class="form-control" name="user_password" type="text" required>
  </div>
  <div class="form-group">
    <label for="user_password">Confirm Password</label>
      <input class="form-control" name="confirm_user_password" type="text" required>
  </div>

  <div class="form-group">
    <label for="user_firstname">First Name</label>
      <input class="form-control" name="user_firstname" type="text" required>
  </div>

  <div class="form-group">
    <label for="user_lastname">Last Name</label>
      <input class="form-control" name="user_lastname" type="text" required>
  </div>

  <div class="form-group">
    <label for="user_email">Email Address</label>
      <input class="form-control" name="user_email" type="text">
  </div>

  <div class="form-group">
    <label for="user_image">User Image</label>
      <input class="form-control" name="user_image" type="file">
  </div>

  <div class="form-inline form-group">
    <label for="user_role">User role</label>
    <div>
      <select class="form-control" name="user_role" id="user_role">
        <option value="Subscriber">Subscriber</option>
        <option value="Admin">Admin</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="user_status">User Status</label>
      <input class="form-control" name="user_status" type="text" value="Unapproved" readonly>
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="create_user" value="Add User" type="submit">
  </div>

</form>
