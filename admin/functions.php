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

function find_all_categories () {

  global $connection;

  $query = "SELECT * FROM categories";
  $select_all_categories = mysqli_query ($connection, $query);

  while ($row = mysqli_fetch_assoc ($select_all_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
      echo "<tr>";
      echo "<td>{$cat_id}</td>";
      echo "<td>{$cat_title}</td>";
      echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
      echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
      echo "</tr>";
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

function users_online () {

global $connection;

$session_id = session_id ();
$time = time ();
$timeout_in_seconds = 60;
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

return $howmany_users;
}

?>
