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

                    </div>
                </div>
                <!-- /.row -->
<?php

if (isset ($_POST['update_profile'])) {
  
  $user_id            = $_POST['user_id'];
  $user_name          = $_POST['user_name'];
  $user_password      = $_POST['user_password'];

  $query = "SELECT user_password FROM users WHERE user_id = {$user_id} ";
  $select_password_query = mysqli_query ($connection, $query);
  confirm_query ($select_password_query);

  $row = mysqli_fetch_array ($select_password_query);
  $db_password = $row['user_password'];

  if ($db_password !== $user_password) {
    $user_password = password_hash ($user_password, PASSWORD_BCRYPT, array ('cost' => 10));
  }

  $user_firstname  = $_POST['user_firstname'];
  $user_lastname   = $_POST['user_lastname'];
  $user_email      = $_POST['user_email'];
  $user_role       = $_POST['user_role'];
  $user_image      = $_POST['user_image'];

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

  $query  = "UPDATE users SET ";
  $query .= "user_name = '{$user_name}', ";
  $query .= "user_password = '{$user_password}', ";
  $query .= "user_firstname = '{$user_firstname}', ";
  $query .= "user_lastname = '{$user_lastname}', ";
  $query .= "user_email = '{$user_email}', ";
  $query .= "user_image = '{$user_image}', ";
  $query .= "user_role = '{$user_role}' ";
  $query .= "WHERE user_id={$user_id}";

  $update_user_profile = mysqli_query ($connection, $query);
  confirm_query ($update_user_profile);

  echo "<div class='alert alert-success'>
          Profile successfully updated. 
          <a href='profile.php' class='alert-link'>
            View Profile
          </a>
        </div>";
} else {
  
  if (isset ($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
    $select_user_profile_query = mysqli_query ($connection, $query);

    while ($row = mysqli_fetch_array ($select_user_profile_query)) {
      
      $user_id        = $row['user_id'];
      $user_name      = $row['user_name'];
      $user_password  = $row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname  = $row['user_lastname'];
      $user_email     = $row['user_email'];
      $user_image     = $row['user_image'];
      $user_role      = $row['user_role'];
      $user_status    = $row['user_status'];
?>
            <!-- User information form -->
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
                  <input autocomplete="off" class="form-control" name="user_password" type="password" value="<?php echo $user_password; ?>">
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
<?php
            if (!empty ($user_image)) {
              echo "<img src='../images/$user_image' width='100' alt='image'>";
            }
?>
                  </div>
                  <input class="form-control" name="user_image" type="file">
              </div>

              <div class="form-inline form-group">
                <label for="user_role">User Role</label>
                <input class="form-control" name="user_role" type="text" value="<?php echo $user_role; ?>" readonly>
              </div>

              <div class="form-group">
                <label for="user_status">User Status</label>
                  <input class="form-control" name="user_status" type="text" value="<?php echo $user_status; ?>" readonly>
              </div>

              <div class="form-group">
                  <input class="btn btn-primary" name="update_profile" value="Update Profile" type="submit">
              </div>

            </form>
            <!-- End form -->
<?php
    }
  }
}
?>
            </div>
            <!-- /.container-fluid -->
        </div>

<?php
include "includes/admin_footer.php";
?>
