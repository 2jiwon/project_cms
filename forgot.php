<?php
// https://github.com/PHPMailer/PHPMailer#a-simple-example
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';  
require './classes/config.php';
?>

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
        
        /*
         * configure phpmailer 
         * https://github.com/PHPMailer/PHPMailer#a-simple-example
         */
        
        $mail = new PHPMailer(true);                 // Passing `true` enables exceptions
        try { 
            //Server settings
            $mail->isSMTP();                         // Set mailer to use SMTP
            $mail->Host = Config::SMTP_HOST;         // Specify main and backup SMTP servers
            $mail->Username = Config::SMTP_USER;     // SMTP username
            $mail->Password = Config::SMTP_PASSWORD; // SMTP password
            $mail->Port = Config::SMTP_PORT;         // TCP port to connect to
            $mail->SMTPAuth = true;                  // Enable SMTP authentication
            $mail->SMTPSecure = 'tls';               // Enable TLS encryption, `ssl` also accepted
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('ljwjulian@gmail.com', 'Admin');
            $mail->addAddress($email);               // Name is optional

            //Content
            $mail->isHTML(true);                     // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->Body    = '안녕하세요. 테스트 메일입니다.';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo "<div class='btn btn-info'>Message has been sent</div>";
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
      } else {
        echo "Something's gone wrong.";
      }
    }
  }
}
?>
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

