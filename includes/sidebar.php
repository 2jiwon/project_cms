            <div class="col-md-4">

                <!-- Login panel -->
<?php if (isset ($_SESSION['user_role'])) : ?>
                <div class="well">
                   <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
                   <a class="btn btn-warning" href="includes/logout.php">Log Out</a> 
                </div>
<?php else: ?>
                <div class="collapse panel panel-primary" id="collapseLogin">
                    <div class="panel-heading"><a class="btn-primary" href="login.php"> Log In </a></div> 

                    <!-- Login form -->
                    <div class="panel-body">
                      <form action="includes/login.php" method="post">
                        <div class="form-group"> 
                          <input class="form-control" name="username" type="text" placeholder="Enter Username">
                        </div>
                        <div class="input-group">
                          <input class="form-control" name="password" type="password" placeholder="Enter Password">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">Login</button>
                          </span>
                        </div>
                      <!-- /.input-group -->
                      </form>
                    </div>
                </div>
<?php endif; ?>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
  
                    <!-- Search form -->
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input class="form-control" name="search" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-default" name="submit" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                    </form>
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">

<?php

$stmt = mysqli_prepare ($connection, "SELECT cat_id, cat_title FROM categories ");

mysqli_stmt_execute ($stmt);
mysqli_stmt_store_result ($stmt);
mysqli_stmt_bind_result ($stmt, $cat_id, $cat_title);

while (mysqli_stmt_fetch ($stmt)) {
    echo "<li><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
}

?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
<?php
include "includes/widget.php";
?>
          </div>
