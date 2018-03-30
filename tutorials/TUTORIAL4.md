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

- Cut the 'Dropdown' parts, move it to the next of 'Dashboard'.
Then rename its <ul id>, 'data-target' as 'Posts_dropdown'.
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
> Dashboard, Posts, Categories, Comments, Users, Profile

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
