<?php 
include "db.php"; 
include "../admin/functions.php";
?>

<?php
session_start ();
?>

<?php

if (isset ($_POST['login'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $username = mysqli_real_escape_string ($connection, $username);
  $password = mysqli_real_escape_string ($connection, $password);

  $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
  $select_user_query = mysqli_query ($connection, $query);
  confirm_query ($select_user_query);

  while ($row = mysqli_fetch_array ($select_user_query)) {
    $db_user_id         = $row['user_id'];
    $db_username        = $row['user_name'];
    $db_password        = $row['user_password'];
    $db_user_firstname  = $row['user_firstname'];
    $db_user_lastname   = $row['user_lastname'];
    $db_user_role       = $row['user_role'];
  }

  //$password = crypt ($password, $db_password); 

  //if ($username === $db_username && $password === $db_password) {

  if (password_verify ($password, $db_password)) {
    $_SESSION['username']  = $db_username;
    $_SESSION['firstname'] = $db_user_firstname;
    $_SESSION['lastname']  = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;

    header ("Location: ../admin");
  } else {
    header ("Location: ../index.php");
  }
}


?>
