<?php

function confirm_query ($result) {

  global $connection; 

  if (!$result) {
    die ("QUERY FAILED" . mysqli_error ($connection));
  }
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
