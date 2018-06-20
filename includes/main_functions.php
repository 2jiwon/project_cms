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

function post_pager ($query, $id, $class, $button) {

  global $connection;

  $get_query = mysqli_query ($connection, $query);
  confirm_query ($get_query); 
  $row = mysqli_fetch_assoc ($get_query);
  $id  = $row['post_id'];

  if (!empty ($id)) {
    echo "<li class='{$class}'>
            <a href='post.php?p_id={$id}'>$button</a>
          </li>";
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

function register_user ($username, $firstname, $lastname, $email, $password) {

  global $connection;

 $username  = $_POST['username'];

 if (field_exists ($username, 'user_name')) {
   die ("<div class='alert alert-danger' role='alert'>
           Sorry, username is already exists. Please enter other username.
           <a class='alert-link' href='./registration.php'> Go Back.</a></div>");
 }

  $firstname = $_POST['firstname'];
  $lastname  = $_POST['lastname'];
  $email     = $_POST['email'];
  $password  = $_POST['password'];

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

?>
