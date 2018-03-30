<?php

$db['db_host'] = "localhost";
$db['db_user'] = "your mysql username";
$db['db_pass'] = "your mysql password";
$db['db_name'] = "cms";

$connection = mysqli_connect ('localhost', 'your mysql username', 'your mysql password', 'cms');

if ($connection) {
echo "we are connected";
}

?>
