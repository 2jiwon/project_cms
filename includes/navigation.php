    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $home_url; ?>">BLOG HOME</a>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
<?php
            $query = "SELECT * FROM categories";
            $stmt  = $connection->prepare ($query);
            $stmt->execute ();
            $result = $stmt->get_result ();

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc ()) {

               $cat_title = $row['cat_title'];
               $cat_id    = $row['cat_id'];

               $category_class       = '';
               $pageName = basename ($_SERVER['PHP_SELF']);

               if (isset ($_GET['category']) && $_GET['category'] == $cat_id) {
                 $category_class = 'active';
                 echo "<li class='$category_class'><a href='category/{$cat_id}'>{$cat_title}</a></li>";
               } else {
              
              //echo "<li class='$category_class'><a href='./{$cat_id}'>{$cat_title}</a></li>";
                echo "<li class='$category_class'><a href='{$home_url}/category/{$cat_id}'>{$cat_title}</a></li>";
               }
              }
            }
?>
<?php if (isset ($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') : ?>
                    <li>
                        <a href="<?php echo $home_url; ?>/admin/index.php">Admin</a>
                    </li>
<?php endif; ?>
                </ul>

                <!-- Button for Log In & Register -->
<?php if (!isset ($_SESSION['user_role'])) : ?>
                <div class="nav navbar-nav navbar-right center-block">
                <a class="btn btn-primary navbar-btn" role="button"
                   href="<?php echo $home_url; ?>/login.php">Log In</a>
                  <!-- <a id="loginBtn" class="btn btn-primary navbar-btn" role="button" data-toggle="collapse" 
                     href="#collapseLogin" aria-expanded="false" aria-controls="collapseLogin">Log In</a> -->
                  <a class="btn btn-default navbar-btn" role="button" href="<?php echo $home_url; ?>/registration">Register</a>
                </div>
<?php endif; ?>
                <!-- /. navbar-btn -->              

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
