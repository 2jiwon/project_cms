<?php

// For Update User's Information
  if (isset ($_POST['update_user'])) {
  
    $user_id         = $_POST['user_id'];
    $user_name       = $_POST['user_name'];
    $user_password   = $_POST['user_password'];
    $user_firstname  = $_POST['user_firstname'];
    $user_lastname   = $_POST['user_lastname'];
    $user_email      = $_POST['user_email'];
    $user_role       = $_POST['user_role'];
  
    $user_image      = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    move_uploaded_file ($user_image_temp, "../images/{$user_image}");
  
    if (empty ($user_image)) {
      $query = "SELECT user_image FROM users WHERE user_id={$user_id} ";
      $select_u_image = mysqli_query ($connection, $query);
  
      while ($row = mysqli_fetch_assoc ($select_u_image)) {
        $user_image = $row['user_image'];
      }
    }
  
    $query = "SELECT * FROM users WHERE user_id = {$user_id} ";
    $select_randsalt_query = mysqli_query ($connection, $query);
    confirm_query ($select_randsalt_query);

    while ($row = mysqli_fetch_array ($select_randsalt_query)) {
      $salt = $row['randSalt'];
      $db_password = $row['user_password'];
    }

    $query  = "UPDATE users SET ";
    $query .= "user_name = '{$user_name}', ";

    if ($db_password !== $user_password) {
      echo 'db'.$db_password;
      echo 'user'.$user_password;
      $hashed_password = crypt ($user_password, $salt);
      echo 'hashed'.$hashed_password;
      $query .= "user_password = '{$hashed_password}', ";
    }

    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_image = '{$user_image}', ";
    $query .= "user_role = '{$user_role}' ";
    $query .= "WHERE user_id={$user_id}";
  
    $update_user = mysqli_query ($connection, $query);
  
    confirm_query ($update_user);
    echo "<div class='alert alert-success'>
            User's profile successfully updated. 
              <a href='users.php' class='alert-link'>
                View Users table
              </a>
          </div>";
  } else {
  
    // For Display User's Information for edit
    if (isset ($_GET['u_id'])) {
      $user_id = $_GET['u_id'];
    
      $query = "SELECT * FROM users WHERE user_id ={$user_id}";
      $select_all_users = mysqli_query ($connection, $query);
    
      confirm_query ($select_all_users); 
    
      while ($row = mysqli_fetch_assoc ($select_all_users)) {
        $user_id        = $row['user_id'];
        $user_name      = $row['user_name'];
        $db_password  = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname  = $row['user_lastname'];
        $user_email     = $row['user_email'];
        $user_image     = $row['user_image'];
        $user_role      = $row['user_role'];
        $user_status    = $row['user_status'];
      }
?>

<form action="" method="post" enctype="multipart/form-data">

  <div class="form-inline form-group">
    <label for="user_id">User Id</label>
    <div>
      <input class="form-control" name="user_id" type="text" value="<?php echo $user_id; ?>" readonly>
    </div>
  </div>

  <div class="form-group">
    <label for="user_name">Username</label>
      <input class="form-control" name="user_name" type="text" value="<?php echo $user_name; ?>">
  </div>

  <div class="form-group">
    <label for="user_password">Password</label>
      <input class="form-control" name="user_password" type="text" value="<?php echo $db_password; ?>">
  </div>

  <div class="form-group">
    <label for="user_firstname">First Name</label>
      <input class="form-control" name="user_firstname" type="text" value="<?php echo $user_firstname; ?>">
  </div>

  <div class="form-group">
    <label for="user_lastname">Last Name</label>
    <input class="form-control" name="user_lastname" type="text" value="<?php echo $user_lastname; ?>">
  </div>

  <div class="form-group">
    <label for="user_email">Email Address</label>
    <input class="form-control" name="user_email" type="text" value="<?php echo $user_email; ?>">
  </div>

  <div class="form-group">
    <label for="user_image">User Image</label>
      <div>
        <img src="../images/<?php echo $user_image; ?>" width="100" alt="image">
      </div>
      <input class="form-control" name="user_image" type="file">
  </div>

  <div class="form-inline form-group">
    <label for="user_role">User Role</label>
    <div>
      <select class="form-control" name="user_role" id="user_role">
      <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
<?php
      if ($user_role === 'Admin') {
        echo "<option value='Subscriber'>Subscriber</option>";
      } else {
        echo "<option value='Admin'>Admin</option>";
      }
?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="user_status">User Status</label>
      <input class="form-control" name="user_status" type="text" value="<?php echo $user_status; ?>" readonly>
  </div>

  <div class="form-group">
      <input class="btn btn-primary" name="update_user" value="Edit User" type="submit">
  </div>

</form>
<?php
    }
} // End of first 'else'
?>
