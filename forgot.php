<?php
include "includes/db.php";
include "includes/header.php";
include "includes/main_functions.php";
?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<?php 
  if (!IsItMethod('get') && !isset($_GET['id'])) {
    redirect ('index');
  }
?>

<?php

if (IsItMethod('post')) {
  if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $length = 50;
    $token = bin2hex(openssl_random_pseudo_bytes($length));  

    if (field_exists ($email, 'user_email')) {
      $query = "UPDATE users SET token='{$token}' WHERE user_email = ? ";

      if ($stmt  = $connection->prepare ($query)) {
        $stmt->bind_param ("s", $email);
        $stmt->execute();
      } else {
        echo "Something's gone wrong.";
      }
    }
  }
}

?>
<!-- Page Content -->
<div class="container">

  <div class="form-gap"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="text-center">

              <h3><i class="fa fa-lock fa-4x"></i></h3>
              <h2 class="text-center">Forgot Password?</h2>
              <p>You can reset your password here.</p>
              <div class="panel-body">


                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                      <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                    </div>
                  </div>
                  <div class="form-group">
                   <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                  </div>

                  <input type="hidden" class="hide" name="token" id="token" value="">
                </form>

              </div><!-- /.panel-body-->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <?php include "includes/footer.php";?>

</div> <!-- /.container -->

