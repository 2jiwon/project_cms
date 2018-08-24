<?php
require_once '../vendor/fzaninotto/faker/src/autoload.php';
include "../includes/db.php";
include "../includes/main_functions.php";

$faker = Faker\Factory::create();

// for categories
//for ($i = 0; $i < 5; $i++) {
//  $cat_title = $faker->word;
//  echo $cat_title."<br>";
//
//  $stmt = $connection->prepare ("INSERT INTO categories (cat_title) VALUES (?) ");
//  $stmt->bind_param ("s", $cat_title);
//
//  if (!$stmt->execute ()) {
//    echo $stmt->error;
//  }
//}  

// for users
//for ($i = 0; $i < 5; $i++) {
//  $user_name      = $faker->username;
//  $user_password  = $faker->password;
//  $user_password = password_hash ($user_password, PASSWORD_BCRYPT, array ('cost' => 10));
//  $user_firstname = $faker->firstName($gender = null);
//  $user_lastname  = $faker->lastName;
//  $user_email     = $faker->email;
//  $user_image     = $faker->image($dir='../images', $width=200, $height=100, 'people');
//  
//  $query  = "INSERT INTO users (user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
//  $query .= "VALUES ('{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', 'Subscriber') ";
//  $create_user_query = mysqli_query ($connection, $query);
//  confirm_query ($create_user_query);
//}

// for posts
//for ($i = 0; $i < 25; $i++) {
//  $post_category_id = $faker->biasedNumberBetween($min = 1, $max = 5, $function = 'sqrt');
//  $post_title       = $faker->sentence($nbWords = 5, $variableNbWords = true);
//  $author           = $faker->biasedNumberBetween($min = 1, $max = 7, $function = 'sqrt');
//
//  $query = "SELECT user_name FROM users WHERE user_id = ? ";
//  $stmt   = $connection->prepare ($query);
//  $stmt->bind_param ("i", $author);
//  $stmt->execute();
//  $result = $stmt->get_result ();
//  $row    = $result->fetch_assoc ();
//  $post_author = $row['user_name'];
//
//  $post_date1       = $faker->date($format = 'Y-m-d');
//  $post_date2       = $faker->time($format = 'H:i:s');
//  $post_date        = $post_date1.' '.$post_date2;
//  $post_image       = $faker->image($dir='../images', $width=640, $height=480);
//  $post_content     = $faker->paragraph($nbSentences = 20, $variableNbSentences = true);
//  $post_tags        = $faker->word;
//  
//  $query  = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags) ";
//  $query .= "VALUES ( ?, ?, ?, ?, ?, ?, ? ) ";
//  
//  $stmt   = $connection->prepare ($query);
//  $stmt->bind_param ("issssss", $post_category_id, $post_title, $post_author, $post_date, $post_image, $post_content, $post_tags);
//  if (!$stmt->execute ()) {
//    echo $stmt->error;
//  }
//}

//$stmt->close();
?>
