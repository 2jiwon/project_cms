<?php  
include "includes/db.php";
include "includes/header.php";
include "includes/main_functions.php";
?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
 
    <!-- Page Content -->
    <div class="container">

<?php

if (isset ($_POST['submit'])) {

  $username  = trim ($_POST['username']);
  $firstname = trim ($_POST['firstname']);
  $lastname  = trim ($_POST['lastname']);
  $email     = trim ($_POST['email']);
  $password  = trim ($_POST['password']);

  $error = [
    'username'  => '',
    'firstname' => '',
    'lastname'  => '',
    'email'     => '',
    'password'  => ''
  ];

  if (strlen ($username) < 4) {
    $error['username'] = 'Username needs to be longer';
  }  

  if (field_exists ($username, 'user_name')) {
    $error['username'] = "<div class='alert alert-danger' role='alert'>
       <p>Sorry, username already exists. Please enter other username.</p>
       <p>If you already had an ID, please <a class='alert-link' href='index.php'>Log in.</a></p></div>";
  }

  if (field_exists ($email, 'user_email')) {
    $error['email'] = "<div class='alert alert-danger' role='alert'>
       <p>Sorry, user email already exists. Please check your email address.</p>
       <p>If you already had an ID, please <a class='alert-link' href='index.php'>Log in.</a></p></div>";
  }

  foreach ($error as $key => $value) {
    if (empty ($value)) {
      unset ($error[$key]); 
    }
  }

  if (empty ($error)) {
    register_user ($username, $firstname, $lastname, $email, $password);
    login ($username, $password);
  }
}

?>

<section id="registration">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-wrap">
                <h1 class="page-header text-center">Registration</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" 
                                   value="<?php echo isset($username) ? $username : '' ?>"
                                   placeholder="Enter Desired Username" autocomplete="on" required>
                            <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" 
                                   value="<?php echo isset($firstname) ? $firstname : '' ?>"
                                   placeholder="Enter First name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control"
                                   value="<?php echo isset($lastname) ? $lastname : '' ?>"
                                   placeholder="Enter Last name" required>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="<?php echo isset($email) ? $email : '' ?>"
                                   placeholder="Enter Email Address e.g. somebody@example.com" required>
                            <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Enter Password" required>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-info btn-lg btn-block" value="Sign Up">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div>  <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>
