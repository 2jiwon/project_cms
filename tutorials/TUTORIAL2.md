## Insert data into table and display

1. Change the table name **_category_** --> **_categories_**
```sql
MariaDB [cms]> RENAME TABLE category TO categories;
```

2. Insert values into title 'bootstrap','javascript' for test.
```sql
MariaDB [cms]> insert into categories (cat_title) values ('bootstrap');
MariaDB [cms]> insert into categories (cat_title) values ('javascript');
```

3. Open **_navigation.php_**, modify the menu part.

4. write the query parts to display the category titles.
```php
$query = "SELECT * FROM categories";
$select_all_categories_query = mysqli_query ($connection, $query);

while ($row = mysqli_fetch_assoc ($select_all_categories_query)) {
  $cat_title = $row['cat_title'];
  echo "<li><a href='#'>{$cat_title}</a></li>";
}
```
Do not worry about these codes, we are gonna refactoring them later. 

5. Make sure including **_db.php_** file to index.php.


## Creating posts table

1. Create another table **_posts_**
```sql

CREATE TABLE posts (
    post_id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY
    ,post_category_id INT(3) NOT NULL
    ,post_title VARCHAR(255) NOT NULL
    ,post_author VARCHAR(255) NOT NULL
    ,post_date DATETIME NOT NULL
    ,post_image TEXT
    ,post_content TEXT
    ,post_tags VARCHAR(255) NOT NULL
    ,post_comment_count INT(11) NOT NULL
    ,post_status VARCHAR(255) NOT NULL DEFAULT 'draft'
);

MariaDB [cms]> explain posts;
+--------------------+--------------+------+-----+---------+----------------+
| Field              | Type         | Null | Key | Default | Extra          |
+--------------------+--------------+------+-----+---------+----------------+
| post_id            | int(3)       | NO   | PRI | NULL    | auto_increment |
| post_category_id   | int(3)       | NO   |     | NULL    |                |
| post_title         | varchar(255) | NO   |     | NULL    |                |
| post_author        | varchar(255) | NO   |     | NULL    |                |
| post_date          | datetime     | NO   |     | NULL    |                |
| post_image         | text         | YES  |     | NULL    |                |
| post_content       | text         | YES  |     | NULL    |                |
| post_tags          | varchar(255) | NO   |     | NULL    |                |
| post_comment_count | int(11)      | NO   |     | NULL    |                |
| post_status        | varchar(255) | NO   |     | draft   |                |
+--------------------+--------------+------+-----+---------+----------------+
```

## Insert data into the posts table and display

1. Insert datas

```sql
INSERT INTO POSTS (post_category_id, post_title, post_author, post_date, post_content, post_tags) VALUES
(1, 'This is the first post', jiwon, now(), 'This is the first post in cms blog.', 'jiwon', 'php,javascript');

INSERT INTO POSTS (post_category_id, post_title, post_author, post_date, post_content, post_tags) VALUES
(2, 'This is the second post', jiwon, now(), 'This is the second post in cms blog.', 'jiwon', 'php,cms');
```
2. Insert images

