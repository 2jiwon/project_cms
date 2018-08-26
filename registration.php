<?php  
include "includes/db.php";
include "includes/header.php";
include "includes/main_functions.php";

?>
<?php

$app_id = getenv('APP_ID');
$app_key = getenv('APP_KEY');
$app_secret = getenv('APP_SECRET');
$app_cluster = array(
  'cluster'   => 'ap1',
  'encrypted' => true
);

$pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, $app_cluster);

?>

    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
 
    <!-- Page Content -->
    <div class="container">

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

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

    $data['message'] = $username;
    $pusher->trigger ('notifications', 'new_user', $data);

    login ($username, $password);
  }

}

?>

<section id="registration">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">

          <div class="panel panel-default">
            <div class="panel-body">              
			  <div class="text-center">

                <h2 class="text-center">Registration</h2>
				<div class="panel-body">

                  <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">
                    <div class="form-group">
					  <div class="input-group">
				        <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                        <input type="text" name="username" id="username" class="form-control" 
                               value="<?php echo isset($username) ? $username : '' ?>"
                               placeholder="Enter Desired Username" autocomplete="on" required>
                        <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                      </div>
                    </div>

                     <div class="form-group">
					  <div class="input-group">
				        <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                        <input type="text" name="firstname" id="firstname" class="form-control" 
                               value="<?php echo isset($firstname) ? $firstname : '' ?>"
                               placeholder="Enter First name" required>
                      </div>
                     </div>

                     <div class="form-group">
					  <div class="input-group">
				        <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                        <input type="text" name="lastname" id="lastname" class="form-control"
                               value="<?php echo isset($lastname) ? $lastname : '' ?>"
                               placeholder="Enter Last name" required>
                       </div>
                     </div>

                     <div class="form-group">
					  <div class="input-group">
				        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                        <input type="email" name="email" id="email" class="form-control"
                               value="<?php echo isset($email) ? $email : '' ?>"
                               placeholder="Enter Email Address e.g. somebody@example.com" required>
                        <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                      </div>
                     </div>

                     <div class="form-group">
					  <div class="input-group">
				        <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                        <input type="password" name="password" id="key" class="form-control" placeholder="Enter Password" required>
                      </div>
                     </div>
               
                     <input type="submit" name="submit" id="btn-login" class="btn btn-info btn-lg btn-block" value="Sign Up">
                  </form>
                  
                </div> <!-- /.panel-body-->
              </div> <!--/.text-center -->
            </div> <!-- /.panel-body -->
          </div> <!-- /.panel-body -->
        </div> <!-- /.col-xs-12 -->
      </div>  <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>


