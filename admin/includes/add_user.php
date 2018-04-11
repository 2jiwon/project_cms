<?php

if (isset ($_POST['create_user'])) {
  
  //$user_id = $_POST['user_id'];
  $user_name = $_POST['user_name'];
  $user_password = $_POST['user_password'];
  $user_firstname = $_POST['user_firstname'];
  $user_lastname = $_POST['user_lastname'];

  $user_image = $_FILES['user_image']['name'];
  $user_image_temp = $_FILES['user_image']['tmp_name'];
  move_uploaded_file ($user_image_temp, "../images/{$user_image}");

  if (empty ($user_image)) {
    $user_image = '';
  }

  $user_role = $_POST['user_role'];

  $query  = "INSERT INTO users (user_id, user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
  $query .= "VALUES ('{$user_id}', '{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}') ";

  $create_user_query = mysqli_query ($connection, $query);
  confirm_query ($create_user_query); 
}
  
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-inline form-group">
    <label for="user_id">User Id</label>
    <div>
      <!-- <select class="form-control" name="user_id" id="user_id">
<?php
#  $query = "SELECT * FROM categories"; 
#  $select_categories_id = mysqli_query ($connection, $query);
#
#  confirm_query ($select_categories_id);
#
#  while ($row = mysqli_fetch_assoc ($select_categories_id)) {
#    $user_category_id = $row['cat_id'];
#    $cat_title = $row['cat_title'];
#
#    echo "<option value='{$user_category_id}'>{$cat_title}</option>";
#  }
?>  
      </select> -->
    </div>
  </div>

  <div class="form-group">
    <label for="user_name">Username</label>
      <input class="form-control" name="user_name" type="text" required>
  </div>

  <div class="form-group">
    <label for="user_password">User Password</label>
      <input class="form-control" name="user_password" type="password" required>
  </div>

  <div class="form-group">
    <label for="user_firstname">User Firstname</label>
      <input class="form-control" name="user_firstname" type="text">
  </div>

  <div class="form-group">
    <label for="user_lastname">User Lastname</label>
      <input class="form-control" name="user_lastname" type="text">
  </div>

  <div class="form-group">
    <label for="user_email">User Email</label>
      <input class="form-control" name="user_email" type="email">
  </div>

  <div class="form-group">
    <label for="user_image">User Image</label>
      <input class="form-control" name="user_image" type="file">
  </div>

  <div class="form-group">
    <label for="user_role">User Role</label>
      <select class="form-control" name="user_role" id="user_role">
      <option value="Subscriber">Select</option>
        <option value="Admin">Admin</option>
        <option value="Subscriber">Subscriber</option>
      </select>
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="create_user" value="Add User" type="submit">
  </div>

</form>
