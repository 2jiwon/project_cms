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
  $username  = $_POST['username'];
  $firstname = $_POST['user_firstname'];
  $lastname  = $_POST['user_lastname'];
  $email     = $_POST['email'];
  $password  = $_POST['password'];

  $username  = mysqli_real_escape_string ($connection, $username);
  $firstname = mysqli_real_escape_string ($connection, $firstname);
  $lastname  = mysqli_real_escape_string ($connection, $lastname);
  $email     = mysqli_real_escape_string ($connection, $email);
  $password  = mysqli_real_escape_string ($connection, $password);

  // Using BCRYPT
  $password = password_hash ($password, PASSWORD_DEFAULT, array ('cost' => 10));
  
  $query  = "INSERT INTO users (user_name, user_firstname, user_lastname, user_email, user_password, user_role) ";
  $query .= "VALUES ('{$username}', '{$firstname}', '{$lastname}', '{$email}', '{$password}', 'Subscriber') ";
  $register_query = mysqli_query ($connection, $query);
  confirm_query ($register_query);
  
  echo "<div class='alert alert-info' role='alert'>You are registered successfully.</div>";
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
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last name" required>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email Address e.g. somebody@example.com" required>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Enter Password">
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
