<?php

if (isset ($_POST['checkBoxArray'])) {
  
  foreach ($_POST['checkBoxArray'] as $checkboxValue) {
    $bulk_options = $_POST['bulk_options']; 

    switch ($bulk_options) {
      case 'publish':
        $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'draft'  :
        $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'clone'  :
        $query = "SELECT * FROM posts WHERE post_id = ? ";
        $stmt = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        $stmt->execute ();
        
        $result = $stmt->get_result ();

        while ($row = $result->fetch_assoc ()) {
          $post_category_id = $row['post_category_id'];
          $post_title       = $row['post_title'];
          $post_author      = $row['post_author'];
          $post_date        = $row['post_date'];
          $post_image       = $row['post_image'];
          $post_content     = $row['post_content'];
          $post_tags        = $row['post_tags'];
          $post_view_count  = $row['post_view_count'];
          $post_status      = $row['post_status'];
        }

        $query  = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_view_count, post_status) ";
        $query .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";
        $stmt   = $connection->prepare ($query);
        $stmt->bind_param ("issssssss", $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags, $post_view_count, $post_status);
        break;

      case 'reset':
        $query = "UPDATE posts SET post_view_count = 0 WHERE post_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'delete':
        $query = "DELETE FROM posts WHERE post_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;
      }
      
      $stmt->execute ();
      header ("Location: posts.php");
  }
}

?>
<form action="" method="post">  

<table class="table table-bordered table-hover">

    <div class="row">
      <div class="form-inline">
        <div id="bulkOptionsContainer" class="col-md-6">
          <div class="input-group">
            <select class="form-control" id="" name="bulk_options">
              <option value="">Select Options</option>
              <option value="draft">Draft</option>
              <option value="publish">Publish</option>
              <option disabled>--------------</option>
              <option value="clone">Clone</option>
              <option value="delete">Delete</option>
              <option value="reset">Reset</option>
            </select>
            <div class="input-group-btn">
              <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>
          </div>

          <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
        </div>
      </div>

      <nav aria-label="..." id="custom_nav" class="col-md-6 text-right">
        <ul class="pagination pagination-sm">
<?php
$user = $_SESSION['username'];

if (is_admin ($user)) {
  // Count total posts and set the variables for pagination 
  $query  = "SELECT * FROM posts ";
  $stmt   = $connection->prepare ($query);
  $stmt->execute ();
  $total_posts_query = $stmt->get_result ();
  $total_posts = $total_posts_query->num_rows;
} else {
  // Count total posts and set the variables for pagination 
  $query  = "SELECT * FROM posts WHERE post_author = ? ";
  $stmt   = $connection->prepare ($query);
  $stmt->bind_param ("s", $user);
  $stmt->execute ();
  $total_posts_query = $stmt->get_result ();
  $total_posts = $total_posts_query->num_rows;
}

// How many posts to display for each page
$per_page = 10;
// last_page means total pages;
$last_page = ceil ($total_posts / $per_page);
// How many numbers to display for a set of pagination
$pageset = 5;

if (isset ($_GET['page'])) {
  $pagenum = preg_replace('#[^0-9]#', '', $_GET['page']);
} else {
  $pagenum = 1;
}

if ($pagenum < 1) {
  $pagenum = 1;
} else if ($pagenum > $last_page) {
  $pagenum = $last_page;
}

$start = ($pagenum - 1) * $per_page;
?>

<?php

if ($last_page != 1) {

  if ($pagenum > 1) {
    $prev_page = $pagenum - 1;

    echo "<li class='page-item'>
            <a class='page-link' href='posts.php?page={$prev_page}' aria-label='Previous'>
              <span aria-hidden='true'>&laquo;</span>
              <span class='sr-only'>Previous</span>
            </a>";
  } else {
    echo "<li class='page-item disabled'>
           <span aria-hidden='true'>&laquo;</span>";
  }
    echo "</li>";

$startnum = (floor($pagenum / $pageset) * $pageset) + 1;
if ($pagenum < $startnum) {
  $startnum = (floor (($pagenum - 1) / $pageset) * $pageset) + 1;
}

 for ($i = $startnum; $i < $pagenum; $i++) {
    if ($i > 0 && $i >= $startnum) {
      echo "<li>
              <a href='posts.php?page={$i}'>{$i}</a>
            </li>";
    }
  }

    echo "<li class='active'>
            <a href='posts.php?page={$pagenum}'>{$pagenum}<span class='sr-only'>(current)</span></a>
          </li>";

  for ($i = $pagenum + 1; $i <= ($pagenum + $pageset - 1); $i++) {
    if ($pagenum % $pageset == 0 || $i > $last_page) {
       break;
    }

    echo "<li>
              <a href='posts.php?page={$i}'>{$i}</a>
          </li>";
    if ($i % $pageset == 0) {
      break;
    }
  }

  if ($pagenum != $last_page) {
    $next_page = $pagenum + 1;
    echo "<li class='page-item'>
            <a class='page-link' href='posts.php?page={$next_page}' aria-label='Next'>
              <span aria-hidden='true'>&raquo;</span>
              <span class='sr-only'>Next</span>
            </a>";
  } else {
    echo "<li class='page-item disabled'>
           <span aria-hidden='true'>&raquo;</span>";
  }
    echo "</li>";
}
?>
        </ul>
      </nav>

    </div>
    <p></p>

  <thead>
    <tr>
      <th><input type="checkbox" name="" id="selectAllBoxes"></th>
      <th>Id</th>
      <th>Category</th>
      <th>Title</th>
      <th>Author</th>
      <th>Date</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Views</th>
      <th>Status</th>
      <th>Publish</th>
      <th>Draft</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
<tbody>


<?php
$user = $_SESSION['username'];

if (is_admin ($user)) {
  // Join posts & categories table to pull out their records in one query.
  $query  = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, ";
  $query .= "posts.post_image, posts.post_tags, posts.post_view_count, posts.post_status, ";
  $query .= "categories.cat_id, categories.cat_title FROM posts ";
  $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
  $query .= "ORDER BY posts.post_id DESC LIMIT  ?, ? ";
  $stmt = $connection->prepare ($query);
  $stmt->bind_param ("ii", $start, $per_page);
} else {
  // Join posts & categories table to pull out their records in one query.
  $query  = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_author, posts.post_date, ";
  $query .= "posts.post_image, posts.post_tags, posts.post_view_count, posts.post_status, ";
  $query .= "categories.cat_id, categories.cat_title FROM posts ";
  $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
  $query .= "WHERE posts.post_author = ? ";
  $query .= "ORDER BY posts.post_id DESC LIMIT  ?, ? ";
  $stmt = $connection->prepare ($query);
  $stmt->bind_param ("sii", $user, $start, $per_page);
}

  $stmt->execute();
  $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $post_id          = $row['post_id'];
      $post_category_id = $row['post_category_id'];
      $post_title       = $row['post_title'];
      $post_author      = $row['post_author'];
      $post_date        = $row['post_date'];
      $post_image       = $row['post_image'];
      $post_tags        = $row['post_tags'];
      $post_view_count  = $row['post_view_count'];
      $post_status      = $row['post_status'];
      $cat_id           = $row['cat_id'];
      $cat_title        = $row['cat_title'];

      echo "<tr>";
?>
  <td><input class="checkboxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>

<?php
    echo "<td>{$post_id}</td>
          <td>{$cat_title}</td>
          <td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>
          <td>{$post_author}</td>
          <td>{$post_date}</td>
          <td><img class='img-responsive' width='100' src='../images/{$post_image}' alt='{$post_image}'></td>
          <td>{$post_tags}</td>";

    // Get the numbers of comments 
    $query = "SELECT * FROM comments WHERE comment_post_id = ? ";
    $stmt  = $connection->prepare ($query);
    $stmt->bind_param ("i", $post_id);
    $stmt->execute ();
    $res = $stmt->get_result ();
    $count_comments = $res->num_rows;

    echo "<td><a href='./post_comments.php?c_id={$post_id}'>{$count_comments}</a></td>";
    echo "<td>{$post_view_count}</td>";
    echo "<td>{$post_status}</td>";
    echo "<td><a href='posts.php?publish={$post_id}'>Publish</a></td>";
    echo "<td><a href='posts.php?draft={$post_id}'>Draft</a></td>";
    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
    echo "<td><a data-toggle='modal' data-target='#delete{$post_id}'>Delete</a></td>";
    echo "</tr>";
    
    delete_modal ($post_id, 'post', 'posts.php');
  }
?>

</tbody>
</table>
</form>
<?php

if (isset ($_GET['publish'])) {
  $post_id_for_publish = $_GET['publish'];

  $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = ? ";
  $stmt = $connection->prepare ($query);
  $stmt->bind_param ("i", $post_id_for_publish);
  $stmt->execute();
  header ("Location: posts.php");
}

if (isset ($_GET['draft'])) {
  $post_id_for_draft = $_GET['draft'];

  $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = ? ";
  $stmt = $connection->prepare ($query);
  $stmt->bind_param ("i", $post_id_for_draft);
  $stmt->execute();
  header ("Location: posts.php");
}

if (isset ($_POST['delete'])) {
  $post_id_for_delete = $_POST['id'];

  $query = "DELETE FROM posts WHERE post_id = ? ";
  $stmt = $connection->prepare ($query);
  $stmt->bind_param ("i", $post_id_for_delete);
  $stmt->execute();
  header ("Location: posts.php");
}
?>
