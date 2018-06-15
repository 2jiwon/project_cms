<?php
if (isset ($_POST['checkBoxArray'])) {
  
  foreach ($_POST['checkBoxArray'] as $checkboxValue) {
    $bulk_options = $_POST['bulk_options']; 

    switch ($bulk_options) {
      case 'approve':
        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$checkboxValue} ";
        break;
      case 'disapprove':
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$checkboxValue} ";
        break;

      case 'clone':
        $query  = "SELECT * FROM comments WHERE comment_id = {$checkboxValue} ";
        $select_comment = mysqli_query ($connection, $query);
        confirm_query ($select_comment);

        while ($row = mysqli_fetch_assoc ($select_comment)) {
          $comment_post_id = $row['comment_post_id'];
          $comment_author  = $row['comment_author'];
          $comment_email   = $row['comment_email'];
          $comment_content = $row['comment_content'];
          $comment_status  = $row['comment_status'];
          $comment_date    = $row['comment_date'];
        }

        $query  = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
        $query .= "VALUES ('{$comment_post_id}', '{$comment_author}', '{$comment_email}', '{$comment_content}', '{$comment_status}', '{$comment_date}') ";
        break;

      case 'delete':
        $query = "DELETE FROM comments WHERE comment_id = {$checkboxValue} ";
        break;
    }

    $bulk_query = mysqli_query ($connection, $query);
    confirm_query ($bulk_query);
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

$query = "SELECT * FROM comments";
$select_all_comments = mysqli_query ($connection, $query);
confirm_query ($select_all_comments);

  while ($row = mysqli_fetch_assoc ($select_all_comments)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_email = $row['comment_email'];
    $comment_content = $row['comment_content'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];

    echo "<tr>
          <td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='{$comment_id}'></td>
          <td>{$comment_id}</td>";

    $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
    $comment_post = mysqli_query ($connection, $query);

    while ($row = mysqli_fetch_assoc ($comment_post)) {
      $post_id     = $row['post_id'];
      $response_to = $row['post_title'];
    }

    echo "<td><a href='../post.php?p_id={$post_id}'>{$response_to}</a></td>
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

    echo "  <!-- Modal for delete -->
            <div id='delete{$comment_id}' class='modal fade' tabindex='-1' role='dialog'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title'>Delete Comment</h4>
                  </div>
                  <div class='modal-body'>
                    <p>Are you sure to delete this comment?</p>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                    <a type='button' class='btn btn-primary' href='comments.php?delete={$comment_id}'>Delete</a>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->";
  }
?>
  </tbody>
  </table>
</form>

<?php

if (isset ($_GET['approve'])) {
  $comment_id_for_approve = $_GET['approve'];

  $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$comment_id_for_approve} ";
  $approve_query = mysqli_query ($connection, $query);

  confirm_query ($approve_query);
  header ("Location: comments.php");
}

if (isset ($_GET['disapprove'])) {
  $comment_id_for_disapprove = $_GET['disapprove'];

  $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$comment_id_for_disapprove} ";
  $disapprove_query = mysqli_query ($connection, $query);

  confirm_query ($disapprove_query);
  header ("Location: comments.php");
}

if (isset ($_GET['delete'])) {
  $comment_id_for_delete = $_GET['delete'];

  $query = "DELETE FROM comments WHERE comment_id = {$comment_id_for_delete} ";
  $delete_query = mysqli_query ($connection, $query);
  confirm_query ($delete_query);
  header ("Location: comments.php");

  //$query  = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
  //$query .= "WHERE post_id = {$post_id} ";
  //$minus_comment_count = mysqli_query ($connection, $query);
  //confirm_query ($minus_comment_count);
}
?>
