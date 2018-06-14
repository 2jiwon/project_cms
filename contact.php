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
  //$mailto   = "support@jiwon.me";
  $mailto   = "ljwjulian@gmail.com";
  $subject  = wordwrap ($_POST['subject'], 70);
  $contents = $_POST['contents'];
  $from     = "From: " . $_POST['email'];

  $result = mail ($mailto, $subject, $contents, $from);

  if ($result) 
    echo "<div class='alert alert-info' role='alert'>Your mail submitted successfully.</div>";
  
} else {
?>

<section id="contact">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-wrap">
                <h1 class="page-header text-center">Contact</h1>
                    <form role="form" action="" method="post" id="contact-form" autocomplete="off">

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email Address e.g. somebody@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Type Subject" required>
                        </div>
                         <div class="form-group">
                            <label for="contents" class="sr-only">Contents</label>
                            <textarea class="form-control" name="contents" cols="30" rows="10" placeholder="Type Contents"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-success btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div>  <!-- /.row -->
    </div> <!-- /.container -->
</section>
<?php
}
?>
        <hr>

<?php include "includes/footer.php";?>
