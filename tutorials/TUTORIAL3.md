## Create custom search engine

1. Add **_search form_** to **_sidabar.php_**
```html
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
```

2. Copy **_index.php_** to **_search.php_** and modify posts part
```html
            <!-- Blog Entries Column -->
            <div class="col-md-8">
<?php
if (isset ($_POST['submit'])) {
  $search = $_POST['search'];

  $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
  $search_query = mysqli_query ($connection, $query);

  if (!$search_query) {
    die ("QUERY FAILED". mysqli_error ($connection));
  }

  $count = mysqli_num_rows ($search_query);

  if ($count == 0) {
    echo "<h1> NO RESULT </h1>";
  } else {

    while ($row = mysqli_fetch_assoc ($search_query)) {
      $post_title   = $row['post_title'];
      $post_author  = $row['post_author'];
      $post_date    = $row['post_date'];
      $post_image   = $row['post_image'];
      $post_content = $row['post_content'];
?>

 <h1 class="page-header">
     Page Heading
     <small>Secondary Text</small>
 </h1>

 ....< skip >
```
If 'submit' value sends from **_sidebar.php_**, it stores as $search.
Then $query makes a search query statement.
If there are no results, the echo works printing 'No result'.
If there is any result, it fetches and makes $post variables and displays.

## Adding categories to the sidebar

1. Copy php codes from **_navigation.php_**, paste them to **_sidabar.php_**.
   Just add below codes inside of <ul></ul> tags.

```html
<?php

$query = "SELECT * FROM categories";
$select_all_categories_query = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_all_categories_query)) {
  $cat_title = $row['cat_title'];

    echo "<li><a href='#'>{$cat_title}</a></li>";
}

?>
```
You can also display limit you want, by add 'LIMIT number' to the query.
```html
$query = "SELECT * FROM categories LIMIT 3";
```
This will display only 3 categories.

2. Modify part **_widget.php_**

Take the widget parts to a new php file named **_widget.php_**.
Do not forget including the **_widget.php_** in the place.

3. (Optional) Take the remained categories parts out in **_sidebar.php_**

There are another 'col-lg-6' parts remained right now.
```html
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
```
If you cut the part out, you can modify our category part's class name, 
'col-lg-6' to 'col-lg-12'. Since the part we cut out had been '6', 
now you can use the whole '12'.

## Create reuseable code in the admin

We're going to make 'Admin page'.

1. Divide **_admin/index.php_** into each **_includes_** files.

Make a **_includes_** directory inside of admin.
Make files **_header.php_**, **_footer.php_**, **_navigation.php_**.
Take each part out from index.php and paste them.

2. Add **_Admin_** category manually to **_navigation.php_**.
```html
 <li>
     <a href="admin/index.php">Admin</a>
 </li>
```
admin/index.php is already made with bootstrap.

3. Add **_Home_** menu in **_admin/includes/navigation.php_** for going back to the first page.
```html
<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">

  <li><a href="../index.php">HOME</a></li>
```

4. Add **_HOME_** menu in out root's navigation, too.

