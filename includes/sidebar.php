            <div class="col-md-4">

                <!-- Login panel -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                      Login
                    </div> 

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

$query = "SELECT * FROM categories";
$select_categories_sidebar = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_categories_sidebar)) {
  $cat_title = $row['cat_title'];
  $cat_id    = $row['cat_id'];

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
