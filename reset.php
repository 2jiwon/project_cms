<?php
include "includes/db.php";
include "includes/header.php";
include "includes/main_functions.php";
?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php

  if (!isset($_GET['email']) && !isset($_GET['token'])) {
    redirect ('index');
  }

  $token = $_GET['token'];

  $query = "SELECT user_name, user_email, token FROM users WHERE token = ? ";

  if ($stmt  = $connection->prepare ($query)) {
    $stmt->bind_param ("s", $token);
    $stmt->execute();
    $stmt->bind_result ($user_name, $user_email, $token);
    $stmt->fetch();
    $stmt->close(); 
    
    if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
      if ($_POST['password'] !== $_POST['confirmPassword']) {
        echo "Please recheck password.";
        exit;
      } else {
        $password = password_hash ($_POST['password'], PASSWORD_BCRYPT, array ('cost' => 10));

        $query = "UPDATE users SET user_password = ? , token = '' WHERE user_name = ? ";

        if ($stmt = $connection->prepare ($query)) {
          $stmt->bind_param("ss", $password, $user_name);
          $stmt->execute();

          if ($stmt->affected_rows > 0) {
            $isChanged = true;
          }
        }
      } 
    }
  }
?>


<!-- Page Content -->
<div class="container">

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="text-center">

              <h3><i class="fa fa-lock fa-4x"></i></h3>
              <h2 class="text-center">Reset Password</h2>
              <p>You can reset your password here.</p>

<?php if (!isset($isChanged)): ?>

              <div class="panel-body">

                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                      <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                      <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                    </div>
                  </div>

                  <div class="form-group">
                    <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                  </div>

                    <input type="hidden" class="hide" name="token" id="token" value="">
                </form>

<?php else: ?>

          <div class='alert alert-success'>Password reset succefully. <a href='login'>Please log in.</a></div>

<?php endIf; ?>

              </div><!-- Body-->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<hr>

<?php include "includes/footer.php";?>

</div> <!-- /.container -->

