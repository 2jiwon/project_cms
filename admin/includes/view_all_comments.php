<?php
if (isset ($_POST['checkBoxArray'])) {
  
  foreach ($_POST['checkBoxArray'] as $checkboxValue) {
    $bulk_options = $_POST['bulk_options']; 

    switch ($bulk_options) {
      case 'approve':
        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'disapprove':
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;

      case 'clone':
        $query  = "SELECT * FROM comments WHERE comment_id = ? ";
        $stmt   = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        $stmt->execute ();
        
        $result = $stmt->get_result ();

        while ($row = $result->fetch_assoc ()) {
          $comment_post_id = $row['comment_post_id'];
          $comment_author  = $row['comment_author'];
          $comment_email   = $row['comment_email'];
          $comment_content = $row['comment_content'];
          $comment_status  = $row['comment_status'];
          $comment_date    = $row['comment_date'];
        }

        $query  = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
        $query .= "VALUES ( ?, ?, ?, ?, ?, ? ) ";

        $stmt   = $connection->prepare ($query);
        $stmt->bind_param ("isssss", $comment_post_id, $comment_author, $comment_email, $comment_content, $comment_status, $comment_date);
        break;

      case 'delete':
        $query = "DELETE FROM comments WHERE comment_id = ? ";
        $stmt  = $connection->prepare ($query);
        $stmt->bind_param ("i", $checkboxValue);
        break;
    }

    $stmt->execute ();
    header ("Location: comments.php");
  }
}
?>

<form action="" method="post">  
  <table class="table table-bordered table-hover">

      <div class="row form-inline">
        <div id="bulkOptionsContainer" class="col-md-6">
          <div class="input-group">
            <select class="form-control" id="" name="bulk_options">
              <option value="">Select Options</option>
              <option value="approve">Approve</option>
              <option value="disapprove">Disapprove</option>
              <option disabled>--------------</option>
              <option value="clone">Clone</option>
              <option value="delete">Delete</option>
            </select>
            <div class="input-group-btn">
              <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>
          </div>
        </div>
      </div>
      <p></p>

    <thead>
      <tr>
        <th><input type="checkbox" name="" id="selectAllBoxes"></th>
        <th>Id</th>
        <th>Response To</th>
        <th>Author</th>
        <th>Email</th>
        <th>comments</th>
        <th>Status</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Disapprove</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      </tr>
    </thead>
  <tbody>

<?php

$user = $_SESSION['username'];

if (is_admin ($user)) {
  // Join comments & posts table to pull out their records in one query.
  $query  = "SELECT comments.comment_id, comments.comment_post_id, comments.comment_author, comments.comment_email, ";
  $query .= "comments.comment_content, comments.comment_status, comments.comment_date, ";
  $query .= "posts.post_id, posts.post_title ";
  $query .= "FROM comments ";
  $query .= "LEFT JOIN posts ON comment_post_id = post_id ";
} else {
  // Join comments & posts table to pull out their records in one query.
  $query  = "SELECT comments.comment_id, comments.comment_post_id, comments.comment_author, comments.comment_email, ";
  $query .= "comments.comment_content, comments.comment_status, comments.comment_date, ";
  $query .= "posts.post_id, posts.post_title ";
  $query .= "FROM comments ";
  $query .= "LEFT JOIN posts ON comment_post_id = post_id ";
  $query .= "WHERE comments.comment_author = '{$user}' ";
}

$select_all_comments = mysqli_query ($connection, $query);
confirm_query ($select_all_comments);

  while ($row = mysqli_fetch_assoc ($select_all_comments)) {
    $comment_id      = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author  = $row['comment_author'];
    $comment_email   = $row['comment_email'];
    $comment_content = $row['comment_content'];
    $comment_status  = $row['comment_status'];
    $comment_date    = $row['comment_date'];
    
    $post_id         = $row['post_id'];
    $response_to     = $row['post_title'];

    echo "<tr>
          <td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='{$comment_id}'></td>
          <td>{$comment_id}</td>
          <td><a href='../post.php?p_id={$post_id}'>{$response_to}</a></td>
          <td>{$comment_author}</td>
          <td>{$comment_email}</td>
          <td>{$comment_content}</td>
          <td>{$comment_status}</td>
          <td>{$comment_date}</td>
          <td><a href='comments.php?approve={$comment_id}'>Approve</a></td>
          <td><a href='comments.php?disapprove={$comment_id}'>Disapprove</a></td>
          <td><a href='comments.php?source=edit_comment&p_id={$comment_id}'>Edit</a></td>
          <td><a data-toggle='modal' data-target='#delete{$comment_id}'>Delete</a></td>
          </tr>";

    delete_modal ($comment_id, 'comment', 'comments.php');
  }
?>
  </tbody>
  </table>
</form>

<?php

if (isset ($_GET['approve'])) {
  $comment_id_for_approve = $_GET['approve'];

  $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = ? ";
  $stmt  = $connection->prepare ($query);
  $stmt->bind_param ("i", $comment_id_for_approve);
  $stmt->execute ();

  header ("Location: comments.php");
}

if (isset ($_GET['disapprove'])) {
  $comment_id_for_disapprove = $_GET['disapprove'];

  $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = ? ";
  $stmt  = $connection->prepare ($query);
  $stmt->bind_param ("i", $comment_id_for_disapprove);
  $stmt->execute ();
  header ("Location: comments.php");
}

if (isset ($_POST['delete'])) {
  $comment_id_for_delete = $_POST['id'];

  $query = "DELETE FROM comments WHERE comment_id = ? ";
  $stmt  = $connection->prepare ($query);
  $stmt->bind_param ("i", $comment_id_for_delete);
  $stmt->execute ();
  header ("Location: comments.php");
}
?>
