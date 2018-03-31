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

## Modify sidebar links in **_navigation.php_** in admin

1. Modify **_admin/includes/navigation.php_**

- Change index link and cut out dropdown menus in header.
```html
<a class="navbar-brand" href="index.html">CMS Admin</a>
...
... skip ...
...
<!-- cut this below out -->
<li class="dropdown">
    <a href="#" class="dropdown-toggle" ...>
    ... skip ...
```

- And only leave the 'profile','log out', cut out the others.
```html
<!-- cut this below out -->
<li>
    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
</li>
... skip ...
```

- At the sidebar menu, we only need '6' menus, so delete '3' menus; Charts,Tables,Forms.

- Cut the 'Dropdown' parts, move it to the next of 'Dashboard'. Then rename its 'ul id', 'data-target' as 'Posts_dropdown'.
Also, rename the menu titles like below.
```html
<li>
    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
    <ul id="posts_dropdown" class="collapse">
        <li>
            <a href="#"> View All Posts </a>
        </li>
        <li>
            <a href="#"> Add Posts </a>
        </li>
    </ul>
</li>
```
- Now, arrange other menus with this order. Make 'Users' also dropdown.
> Dashboard, Posts, Categories, Comments, Users, profile


## Creating admin category page

1. Copy **_admin/index.php_** to  **_admin/categories.php_**

2. We are going to use database in here, so the db.php needs to be included.
Open the **_admin/includes/header.php_** file, include the **_includes/db.php_** file on the top.

3. Test if the db connection works in **_admin/index.php_**
```html
    <small>Subheading</small>
  </h1>
<?php 
  if ($connection) {
    echo "We're connected";
  }
?>
  <ol class="breadcrumb">
```
It works well, so move on.

4. Add a form group in **_admin/categories.php_** 
```html
<div class="col-xs-6">
  <form action="">
    <div class="form-group">
      <label for="cat-title">Add Category</label>
        <input class="form-control" name="cat_title" type="text">
    </div>
    <div class="form-group">
      <input class="btn btn-primary" name="submit" type="submit">
    </div>
  </form>
</div>
```
In this html, see the 'div class' name, 'col-xs-6'.
It is from bootstrap, and it means '6 column of 12, based on mobile screen size'

5. Add a table that shows categories.
```html
<div class="col-xs-6">
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Categoty Title</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>First Category</td>
      <td>Second Category</td>
    </tr>
  </tbody>
</table>
</div>
```

## Displaying data in category page

1. First of all, in order to avoid any confusing later, change the names of include files in admin directory. 
Then modify related links of the files in admin directory.

2. Copy the php parts of categories query in **_includes/navigation.php_**, paste it to **_admin/Categories.php_** inside of <tbody>.
```html
                          <tbody>
<?php

$query = "SELECT * FROM categories";
$select_all_categories = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_all_categories)) {
  $cat_title = $row['cat_title'];
    echo "<li><a href='#'>{$cat_title}</a></li>";
}
?>
                            <tr>
                              <td>First Category</td>
                              <td>Second Category</td>
```

3. Modify it like below.
```html
                          <tbody>
<?php

$query = "SELECT * FROM categories";
$select_all_categories = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_all_categories)) {
  $cat_id = $row['cat_id'];
  $cat_title = $row['cat_title'];
    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "</tr>";
}
?>
                          </tbody>
```

## Adding Categories
Keep modifing admin/categories.php file.

1. Add "method=post" in the form of add category part.
2. Add php codes right above it.
- First, check if any values sent via POST.
```php
if (isset ($_POST['submit'])) {
  echo "It's working";
}
```
- If it's working, then store the sent value as a variable.
```php
if (isset ($_POST['submit'])) {
//  echo "It's working";
  $cat_title = $_POST['cat_title'];
}
```
- Make sure that we will not accept any empty value.
```php
if (isset ($_POST['submit'])) {
  $cat_title = $_POST['cat_title'];

  if ($cat_title == "" || empty ($cat_title)) {
    echo "This field should not be empty.";
  }
}
```
- And if it is not empty, we are going to put the value in database.
```php
  if ($cat_title == "" || empty ($cat_title)) {
    echo "This field should not be empty.";
  } else {
    $query  = "INSERT INTO categories (cat_title) ";
    $query .= "VALUES ('{$cat_title}') ";

    $create_category_query = mysqli_query ($connection, $query);
  }
```
- It will be safe that if the query fails, let it die.
```php
    if (!$create_category_query) {
      die ("QUERY FAILED" . mysqli_error ($connection));
    }
```
3. See if it's working well. Type any category in the form, then it shows right up. And it stored in our database, too.
4. See what if we submit the form empty, too.

## Adding a special function to our header file
Add this on the top of the **_admin/includes/admin_header.php_**.
```PHP
<?php ob_start (); ?>
```
This function is in charge of buffering our request in the headers of scripts.
So when we are done with the script it will send everything at the same time.
Right now, PHP is sending each requests one by one.
So later on, if we use this function 'header ()' in the body, it would give you an error 
if you do not have the 'ob_start ()' function on the top. Because it would try to send our requests 
in the body when all of the headers are already being sent. 

## Deleting Categories

1. Open the **_admin/categories.php_** file. 
Add a 'td' inside of the while statement in the php codes to delete categories.
```php
while ($row = mysqli_fetch_assoc ($select_all_categories)) {
  $cat_id = $row['cat_id'];
  $cat_title = $row['cat_title'];
    echo "<tr>";
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
    echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
    echo "</tr>";
}
```

2. Add this query parts below. To avoid confusing later, you should add comments about what the queries do.
```php
if (isset ($_GET['delete'])) {
  $cat_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM categories WHERE cat_id = {$cat_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);
}
```
Now, if you check how this work, you will see that you have to press the delete twice or refresh the page to see if the categories deleted. So, let's fix it.
All you have to do is, adding this function.
```php
  header ("Location: categories.php");
```
This will refresh the page right up, so you can see the categories deleted.

## Updating or Editing categories
Keep modifying admin/categories.php file.

1. Make another form. Copy the form parts, paste it right below.
Change the label and value as 'Edit'
```html
<form action="" method="post">
  <div class="form-group">
    <label for="cat-title">Edit Category</label>
      <input class="form-control" name="cat_title" type="text">
  </div>
  <div class="form-group">
    <input class="btn btn-primary" name="submit" type="submit" value="Edit">
  </div>
</form>
```

2. Add php code for Edit First after the delete line.
```php
    echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
```

3. Add php query inside of the form that we added before.
```php
                          <form action="" method="post">
                            <div class="form-group">
                              <label for="cat-title">Edit Category</label>
<?php

// Get the cat_id for edit value.
if (isset ($_GET['edit'])) {
  $cat_id = $_GET['edit'];

  $query = "SELECT * FROM categories WHERE cat_id = {$cat_id} ";
  $select_categories_id = mysqli_query ($connection, $query);

  while ($row = mysqli_fetch_assoc ($select_categories_id)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
?>
                            <input class="form-control" name="cat_title" 
                                   value="<?php 
                                               if (isset ($cat_title)) {
                                                  echo $cat_title;
                                               }
                                          ?>"
                                   type="text">
<?php 
  }
}
?>
```

4. Add another query to update the category title
```php
<?php

// Make query to update the category title
if (isset ($_POST['edit'])) {
  $cat_title_for_edit = $_POST['cat_title'];

  $query = "UPDATE categories SET cat_title = '{$cat_title_for_edit}' WHERE cat_id = {$cat_id} ";
  $update_query = mysqli_query ($connection, $query);

  if (!$update_query) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
}
?>
```

5. Make a new file in admin directory as **_update_categories.php_**
6. Take the whole form parts of 'Edit' out, and paste it to the new file.
7. Back to the **_categories.php_** file.
Include the new file where is the place we just cut out.
```php
<?php

if (isset ($_GET['edit'])) {  //<-- this value is from table
  $cat_id = $_GET['edit'];

  include "includes/update_categories.php";
}
?>
```
Now, we can edit categories.


## Refactoring category page
We are going to be condensing codes making it into modular pieces.

1. Make a file named **_functions.php_** in admin directory.

2. Cut the php codes of 'Add categories' part, paste it to the new file.
Then write a function surround the codes.
```php
function insert_categories () {
  // paste it here
}
```
3. Call the new function we just made right the place where the codes were in **_categories.php_**.

4. Do not forget that include the **_functions.php_** file in the **_admin_header.php_**.
```php
include "../includes/db.php";
include "../admin/functions.php";
```

5. Finally, we have to make the 'connection' variable as global one.
```php
function insert_categories () {

  global $connection;

  ... skip ...
```

Keep refactoring category page.

6. Cut the codes of 'select Categories' part, paste it to the
**_functions.php_**.
7. Call the new function just made right the place where the codes were.
8. Do the same as the 'delete categories', 'update_categories' part.
9. For the 'update_categories' part, you need to add 'global $connection' in the
**_update_categories.php_**.
```php
if (isset ($_GET['edit'])) {  //<-- this is not from a form but from a table
  $cat_id = $_GET['edit'];

HERE -->  global $connection;

  $query = "SELECT * FROM categories WHERE cat_id = {$cat_id} ";
  $select_categories_id = mysqli_query ($connection, $query);
```
Check if everything works well.

