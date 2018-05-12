<?php  
include "includes/db.php";
include "includes/header.php";
include "admin/functions.php";
?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
 
    <!-- Page Content -->
    <div class="container">

<?php

if (isset ($_POST['submit'])) {
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $password = $_POST['password'];

  $username = mysqli_real_escape_string ($connection, $username);
  $email    = mysqli_real_escape_string ($connection, $email);
  $password = mysqli_real_escape_string ($connection, $password);

  $query = "SELECT randSalt FROM users ";
  $select_randsalt_query = mysqli_query ($connection, $query);
  confirm_query ($select_randsalt_query);

  while ($row = mysqli_fetch_array ($select_randsalt_query)) {
    $salt = $row['randSalt'];
  }
  $password = crypt ($password, $salt);
  
  $query  = "INSERT INTO users (user_name, user_email, user_password, user_role) ";
  $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'Subscriber') ";
  $register_query = mysqli_query ($connection, $query);
  confirm_query ($register_query);
  
  echo "registration success.";
}

?>

<section id="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-wrap">
                <h1>Sign Up</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Sign Up" required>
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div>  <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>
