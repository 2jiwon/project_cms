<?php
require $_SERVER['DOCUMENT_ROOT'].'/cms/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$db['db_host'] = getenv('DB_HOST');
$db['db_user'] = getenv('DB_USER');
$db['db_pass'] = getenv('DB_PASS');
$db['db_name'] = getenv('DB_NAME');

foreach ($db as $key => $value) {
  define (strtoupper ($key), $value); 
}  

//$connection = mysqli_connect (DB_HOST, DB_USER, DB_PASS, DB_NAME);

$connection = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>
