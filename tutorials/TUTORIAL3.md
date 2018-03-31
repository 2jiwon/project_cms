## Creating a HTML table in admin to display a list of posts
Before everything, make the sidebar links work.
But we do not have posts.php yet, so let's build the page.

1. Copy the **_admin/categories.php_** file to **_admin/posts.php_**.
And the whole parts where is inside of the 'div col-lg-12'.
```html
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

//--> cut out this part

                    </div>
                </div>
                <!-- /.row -->
```
Then paste the header part.
```html
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
```

2. Make a table in **_admin/posts.php_**
```html
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Date</th>
    </tr>
  </thead>
<tbody>
  <tr>
    <td>1</td>
    <td>Jiwon</td>
    <td>Bootstrap</td>
    <td>CSS</td>
    <td>draft</td>
    <td>some.jpg</td>
    <td>CSS</td>
    <td>something</td>
    <td>2018.03.31</td>
  </tr>
</tbody>
</table>
```

3. Modify the table using query.
```php
$query = "SELECT * FROM posts";
$select_all_posts = mysqli_query ($connection, $query);

if (!$select_all_posts) {
  die ("QUERY FAILED" . mysqli_error ($connection));
} else {

  while ($row = mysqli_fetch_assoc ($select_all_posts)) {
    $post_id = $row['post_id'];
    $post_category_id = $row['post_category_id'];
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comments = $row['post_comment_count'];
    $post_status = $row['post_status'];

    echo "<tr>";
    echo "<td>{$post_id}</td>";
    echo "<td>{$post_category_id}</td>";
    echo "<td>{$post_title}</td>";
    echo "<td>{$post_author}</td>";
    echo "<td>{$post_date}</td>";
    echo "<td>{$post_image}</td>";
    echo "<td>{$post_tags}</td>";
    echo "<td>{$post_comments}</td>";
    echo "<td>{$post_status}</td>";
    echo "</tr>";
  };
}
```

4. Modify image part to show actual images.
```php
echo "<td><img class='img-responsive' src='../images/{$post_image}' alt='{$post_image}'></td>";
```

## Including pages based on condition technique

1. Make a new file named **_admin/includes/view_all_posts.php_**.
2. Cut the whole 'table' part out from **_posts.php_**, paste it into the new file.
3. Write some conditional statements that if any source from 'GET' method, then lead to
posts through a 'switch statement'.
```php
if (isset ($_GET['source'])) {
  $source = $_GET['source'];
} else {
  $source = '';
}
  switch ($source) {
    case 'xx':
    break;

    default:
      include "includes/view_all_posts.php";
    break;
  }
```

4. Make another file named **_admin/includes/add_post.php_**.
Write something simple just for a test right now.
```html
  <h1>Hello this is add_post.php</h1>
```
Then modify the previous code a little for the test.
```php
  switch ($source) {
    case 'add_post':
      include "includes/add_post.php";
    break;
```
Now go to the browser, type '?source=add_post' at the end of the url.
> yourhome/cms/admin/posts.php?source=add_post

You can see the add_post.php page.

