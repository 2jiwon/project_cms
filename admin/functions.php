<?php

function confirm_query ($result) {

  global $connection; 

  if (!$result) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
}

function redirect ($location) {

  return header ("Location: ".$location);
}

function insert_categories () {

  global $connection;

  if (isset ($_POST['submit'])) {
    $cat_title = $_POST['cat_title'];

    if ($cat_title == "" || empty ($cat_title)) {
      echo "This field should not be empty.";
    } else {
      $statement1 = mysqli_prepare ($connection, 
        "INSERT INTO categories (cat_title) VALUES (?) ");

      mysqli_stmt_bind_param ($statement1, 's', $cat_title);
      mysqli_stmt_execute ($statement1);

      if (!$statement1) {
        die ("QUERY FAILED" . mysqli_error ($connection));
      }
    }
  }
}

function display_categories () {

  global $connection;

  $statement = mysqli_prepare ($connection, 
    "SELECT cat_id, cat_title FROM categories ");

  mysqli_stmt_execute ($statement);
  mysqli_stmt_bind_result ($statement, $cat_id, $cat_title); 

  while (mysqli_stmt_fetch ($statement)) {

      echo "<tr>";
      echo "<td><input class='checkboxes' type='checkbox' name='checkBoxArray[]' value='{$cat_id}'></td>";
      echo "<td>{$cat_id}</td>";
      echo "<td>{$cat_title}</td>";
      echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
      echo "<td><a data-toggle='modal' data-target='#delete{$cat_id}'>Delete</a></td>";
      echo "</tr>";

      delete_modal ($cat_id, 'category', 'categories.php');
  }
}

function delete_categories () {

  global $connection;

  // Get the cat_id for delete value, make delete query.
  if (isset ($_POST['delete'])) {
    $cat_id_for_delete = $_POST['id'];

    $stmt = mysqli_prepare ($connection,
      "DELETE FROM categories WHERE cat_id = ? ");
    mysqli_stmt_bind_param ($stmt, 'i', $cat_id_for_delete);
    mysqli_stmt_execute ($stmt);

    if (!$stmt) {
      die ("QUERY FAILED" . mysqli_error ($connection));
    }
    //$query = "DELETE FROM categories WHERE cat_id = {$cat_id_for_delete} ";
    //$delete_query = mysqli_query ($connection, $query);

    redirect ("categories.php");
    //header ("Location: categories.php");
  }
}

function update_categories () {
  
  if (isset ($_GET['edit'])) {  //<-- this value is from table
    $cat_id = $_GET['edit'];

    include "includes/update_categories.php";
  }
}

function permission_warning () {
  if (!isset ($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    die ("<div class='alert alert-danger'>
          I'm sorry but you may not have a right permission to see this page.
          <a class='alert-link' href='/cms/'> Back to Home.</a></div>");
  }
}


function users_online () {

  if (isset ($_GET['usersonline'])) {

    global $connection;

    if (!$connection) {
      session_start ();
      include ('../includes/db.php');

    $session_id = session_id ();
    $time = time ();
    $timeout_in_seconds = 300;
    $timeout = $time - $timeout_in_seconds;

    // If this user's in the DB. 
    $query = "SELECT * FROM users_online WHERE session_id = '$session_id'";
    $user_session_query = mysqli_query ($connection, $query);
    confirm_query ($user_session_query);
    $user_count = mysqli_num_rows ($user_session_query);

    // If this user's not in the DB, insert current users id and time.
    // and if this user's in the DB, just update the infomations.
    if ($user_count === 0) {
      $query = "INSERT INTO users_online (session_id, time) VALUES ('$session_id', '$time')";
    } else {
      $query = "UPDATE users_online SET time = '$time' WHERE session_id = '$session_id'";
    }
    $insert_query = mysqli_query ($connection, $query);
    confirm_query ($insert_query);

    // Now show all users online.
    $query = "SELECT * FROM users_online WHERE time > '$timeout'";
    $users_online_query = mysqli_query ($connection, $query);
    $howmany_users = mysqli_num_rows ($users_online_query);

    echo $howmany_users;
    }
  }
}
users_online ();

function delete_modal ($deleteId, $element, $address) {
    echo "  <!-- Modal for delete -->
            <form action='' method='post'>
              <div id='delete{$deleteId}' class='modal fade' tabindex='-1' role='dialog'>
                <div class='modal-dialog' role='document'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                      <h4 class='modal-title'>Delete {$element}</h4>
                    </div>
                    <div class='modal-body'>
                      <p>Are you sure to delete this {$element}?</p>
                    </div>
                    <div class='modal-footer'>";

                    //<a type='button' class='btn btn-primary' href='{$address}?delete={$deleteId}'>Delete</a>

      echo " <input type='hidden' name='id' value='{$deleteId}'>
                     <input class='btn btn-danger' type='submit' name='delete' value='Delete'>

                      <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
             </div><!-- /.modal -->
            </form>";
}

// used 'index.php', displaying Cards
// Count the number of records from each table.
function recordCount ($tableName){
  
  global $connection;

  $query = "SELECT * FROM ".$tableName;
  $select_all_posts_query = mysqli_query ($connection, $query);
  confirm_query ($select_all_posts_query);
  $result = mysqli_num_rows ($select_all_posts_query);

  return $result;
}

// used 'index.php', displaying Charts
// Count the number of records depending on each status from tables. 
function checkStatus ($tableName, $columnName, $status){

  global $connection;

  $query = "SELECT * FROM ".$tableName." WHERE ".$columnName." = '{$status}' "; 
  $select_query = mysqli_query ($connection, $query);
  confirm_query ($select_query);
  $result = mysqli_num_rows ($select_query);

  return $result;
}

?>
