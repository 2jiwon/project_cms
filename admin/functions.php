<?php

function confirm_query ($result) {

  global $connection; 

  if (!$result) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
}


function insert_categories () {

  global $connection;

  if (isset ($_POST['submit'])) {
  //  echo "It's working";
    $cat_title = $_POST['cat_title'];

    if ($cat_title == "" || empty ($cat_title)) {
      echo "This field should not be empty.";
    } else {
      $query  = "INSERT INTO categories (cat_title) ";
      $query .= "VALUES ('{$cat_title}') ";

      $create_category_query = mysqli_query ($connection, $query);

      if (!$create_category_query) {
        die ("QUERY FAILED" . mysqli_error ($connection));
      }
    }
  }
}

function display_categories () {

  global $connection;

  $query = "SELECT * FROM categories";
  $select_all_categories = mysqli_query ($connection, $query);
  confirm_query ($select_all_categories);

  while ($row = mysqli_fetch_assoc ($select_all_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

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
  if (isset ($_GET['delete'])) {
    $cat_id_for_delete = $_GET['delete'];

    $query = "DELETE FROM categories WHERE cat_id = {$cat_id_for_delete} ";
    $delete_query = mysqli_query ($connection, $query);

    header ("Location: categories.php");
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

/* Another way to check if user is admin or not.
function is_admin ($username) {
  
  global $connection;

  $query  = "SELECT user_role FROM users WHERE user_name = '$username' ";
  $result = mysqli_query ($connection, $query);
  confirm_query ($result);

  $row = mysqli_fetch_array ($result); 

  if ($row['user_role'] == 'Admin') {
    return true;
  } else {
    return false;
  }
}

// use this where you want to check
// if (!is_admin ($_SESSION['username'])) {
//    header ("Location: index.php");
// }
*/

function field_exists ($field, $column) {
  
  global $connection;
  
  $query  = "SELECT user_name FROM users WHERE {$column} = '{$field}' ";
  $result = mysqli_query ($connection, $query);
  confirm_query ($result);
  
  if (mysqli_num_rows ($result) > 0) {
    return true;
  } else {
    return false;
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
                  <div class='modal-footer'>
                    <a type='button' class='btn btn-primary' href='{$address}?delete={$deleteId}'>Delete</a>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->";
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
