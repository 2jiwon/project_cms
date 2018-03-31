<?php

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
?>
