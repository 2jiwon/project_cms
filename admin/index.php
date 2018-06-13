<?php
include "includes/admin_header.php";
?>
    <div id="wrapper">

        <!-- Navigation -->
<?php
include "includes/admin_navigation.php";
?>
        <div id="page-wrapper">

            <div class="container-fluid">

<?php
permission_warning ();
?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
<?php
  echo "Welcome to Admin page <small>".$_SESSION['username']."</small>";
  echo "<h2>".$howmany_users."</h2>";
?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>
                                  <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Admin widget -->
                                
                <div class="row">

                    <!-- posts -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
<?php
$query = "SELECT * FROM posts";
$select_all_posts_query = mysqli_query ($connection, $query);
confirm_query ($select_all_posts_query);

$posts_counts = mysqli_num_rows ($select_all_posts_query);

echo "<div class='huge'>{$posts_counts}</div>";
?>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- comments -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
<?php
$query = "SELECT * FROM comments";
$select_all_comments_query = mysqli_query ($connection, $query);
confirm_query ($select_all_comments_query);

$comments_counts = mysqli_num_rows ($select_all_comments_query);

echo "<div class='huge'>{$comments_counts}</div>";
?>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
<?php
$query = "SELECT * FROM users";
$select_all_users_query = mysqli_query ($connection, $query);
confirm_query ($select_all_users_query);
$users_counts = mysqli_num_rows ($select_all_users_query);

echo "<div class='huge'>{$users_counts}</div>";

?>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
<?php
$query = "SELECT * FROM categories";
$select_all_categories_query = mysqli_query ($connection, $query);
confirm_query ($select_all_categories_query);
$categories_counts = mysqli_num_rows ($select_all_categories_query);

echo "<div class='huge'>{$categories_counts}</div>";

?>
                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Admin widget -->

                <!-- Chart -->
                <div class="row">
<?php

// Posts 
$query = "SELECT * FROM posts "; 
$select_posts_query = mysqli_query ($connection, $query);
confirm_query ($select_posts_query);
$published_posts = 0;
$draft_posts = 0;

While ($row = mysqli_fetch_assoc ($select_posts_query)) {
  if ($row['post_status'] == 'Published') {
    $published_posts++;
  } else {
    $draft_posts++;
  }
}

// Comments 
$query = "SELECT * FROM comments ";
$select_comments_query = mysqli_query ($connection, $query);
confirm_query ($select_comments_query);
$approved_comments = 0;
$unapproved_comments = 0;

while ($row = mysqli_fetch_assoc ($select_comments_query)) {
  if ($row['comment_status'] === 'Approved') {
    $approved_comments++;
  } else {
    $unapproved_comments++;
  }
}

// Users 
$query = "SELECT * FROM users";
$select_users_query = mysqli_query ($connection, $query);
confirm_query ($select_users_query);
$approved_users = 0;
$unapproved_users = 0;

while ($row = mysqli_fetch_assoc ($select_users_query)) {
  if ($row['user_status'] === 'Approved') {
    $approved_users++;
  } else {
    $unapproved_users++;
  }
}
?>
                <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);
                
                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],
<?php

$element_text  = [ 'Active Posts', 'Draft Posts', 'Approved Comments', 'Unapproved Comments', 'Approved Users', 'Unapproved Users' ];
$element_count = [ $published_posts, $draft_posts, $approved_comments, $unapproved_comments, $approved_users, $unapproved_users ];

for ($i = 0; $i < 6; $i++) {
  echo "['{$element_text[$i]}', {$element_count[$i]}],";
} 

?>
                        ]);
                
                        var options = {
                          chart: {
                            title: 'Blog Status',
                            subtitle: 'Posts, Comments, Users Status',
                          }
                        };
                
                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                
                    <div class="col-lg-12">
                      <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                    </div>

                </div>
                <!-- End Chart -->

            </div>
            <!-- /.container-fluid -->

        </div>
<?php
include "includes/admin_footer.php";
?>
