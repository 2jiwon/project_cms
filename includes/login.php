<?php 
session_start ();
include "db.php"; 
include "main_functions.php";
?>

<?php

if (isset ($_POST['login'])) {
  login ($_POST['username'], $_POST['password']);
}

?>
