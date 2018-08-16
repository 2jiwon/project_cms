<?php
$home_url = "/cms"; 

function confirm_query ($result) {

  global $connection; 

  if (!$result) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
}

function redirect ($location) {

  header ("Location: ".$location);
  exit;
}

function post_pager ($query, $id, $class, $button) {

  global $connection;

  $get_query = mysqli_query ($connection, $query);
  confirm_query ($get_query); 
  $row = mysqli_fetch_assoc ($get_query);
  $id  = $row['post_id'];

  if (!empty ($id)) {
    echo "<li class='{$class}'>
            <a href='{$id}'>$button</a>
          </li>";
  }
}

function permission_warning () {
  if (!isset ($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    die ("<div class='alert alert-danger'>
          I'm sorry but you may not have a right permission to see this page.
          <a class='alert-link' href='{$home_url}'> Back to Home.</a></div>");
  }
}

// To check if user is admin or not.
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

function register_user ($username, $firstname, $lastname, $email, $password) {

  global $connection;

  $username  = mysqli_real_escape_string ($connection, $username);
  $firstname = mysqli_real_escape_string ($connection, $firstname);
  $lastname  = mysqli_real_escape_string ($connection, $lastname);
  $email     = mysqli_real_escape_string ($connection, $email);
  $password  = mysqli_real_escape_string ($connection, $password);

  // Using BCRYPT
  $password = password_hash ($password, PASSWORD_BCRYPT, array ('cost' => 10));
  
  $query  = "INSERT INTO users (user_name, user_firstname, user_lastname, user_email, ";
  $query .= "user_password, user_role) ";
  $query .= "VALUES ('{$username}', '{$firstname}', '{$lastname}', '{$email}', ";
  $query .= "'{$password}', 'Subscriber') ";
  $register_query = mysqli_query ($connection, $query);
  confirm_query ($register_query);
  
  echo "<div class='alert alert-info' role='alert'>You are registered successfully.</div>";
}

function login ($username, $password) {

  global $connection;
  global $home_url;

  $username = trim ($username);
  $password = trim ($password);

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

  if (password_verify ($password, $db_password)) {
    $_SESSION['username']  = $db_username;
    $_SESSION['firstname'] = $db_user_firstname;
    $_SESSION['lastname']  = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;

    redirect ("{$home_url}/index.php");
  } else {
    echo "<div class='alert alert-danger' role='alert'>Sorry! Something's wrong. <a href='{$home_url}/login'>Try again?</a></div>";
  }
}

// A helper function
function IsItMethod ($method=null) {
  
  if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
    return true;
  }

  return false;
}

function isLoggedIn () {

  if (isset($_SESSION['user_role'])) {
    return true;
  }

  return false;
}

function checkLoggedInAndRedirect ($redirectLocation=null) {
  if (isLoggedIn ()) {
    redirect ($redirectLocation);
  } 
}

?>
