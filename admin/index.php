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

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
<?php
  echo "Welcome to Admin page <small>".$_SESSION['username']."</small>";
?>
                        </h1>
<?php 
#  if ($connection) {
#    echo "We're connected";
#  }
?>
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

                <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);
                
                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Year', 'Sales', 'Expenses', 'Profit'],
                          ['2014', 1000, 400, 200],
                          ['2015', 1170, 460, 250],
                          ['2016', 660, 1120, 300],
                          ['2017', 1030, 540, 350]
                        ]);
                
                        var options = {
                          chart: {
                            title: 'Company Performance',
                            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
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
