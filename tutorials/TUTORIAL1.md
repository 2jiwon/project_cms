## Turning on some important features

Check some settings in your php.ini file.
- display_errors: On
- output_buffering: 4096

Then restart your server.

## Adding assets & setting structures

This lecture actually skipped all the html, css and bootstrap,
because they are another programming area, not the parts of PHP.

1. Download CMS_TEMPLATE.zip, unzip the file.
2. The initial structure of CMS_TEMPLATE

```shell
$ tree -L 2
```
![Alt structure](./tree.png)

3. Make **_images_** directory in the template root directory.
4. Move to admin directory, make another **_images_** directory 
   Then Move to the root directory, again.
5. Change the file names **_.html_** -> **_.php._**

## Make a database

```sql
(connected as root)
CREATE DATABASE IF NOT EXISTS cms;
GRANT ALL PRIVILEGES on cms.* to **_username_**@localhost with GRANT OPTION;
FLUSH PRIVILEGES;

CREATE TABLE category (
    cat_id TINYINT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY
   ,cat_title VARCHAR(255) NOT NULL
);

MariaDB [cms]> explain category;
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| cat_id    | tinyint(3)   | NO   | PRI | NULL    | auto_increment |
| cat_title | varchar(255) | NO   |     | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
```

## Connect to the database (easy way)

1. Make a directory **_includes_**
2. Write a file **_db.php_**

This is an easy way to connect to the database.
```php
$connection = mysqli_connect ('localhost', '{your username}', '{your password}', 'cms');
if ($connection) {
echo "we are connected";
}
```

## Connect to the database (secure way)

This is a very secure way to connect to the database.
1) Put all the infomations into an array.

```php
$db['db_host'] = "localhost";
$db['db_user'] = "{your username}";
$db['db_pass'] = "{your password}";
$db['db_name'] = "cms";
```
2) Make them constatns via strtoupper and define function.
```php
foreach ($db as $key => $value) {
  define (strtoupper ($key), $value); 
}
```
3) Now you can change the previous values like this.
```php
Easy way:
$connection = mysqli_connect ('localhost', '{username}', '{password}', 'cms');
```
```php
Secure way:
$connection = mysqli_connect (DB_HOST, DB_USER, DB_PASS, DB_NAME);
```
## Make files reuseable

1. Divide codes into **_header.php_**, **_footer.php_** from index.php
2. Take **_navigation_** parts out to **_navigation.php_** file.
3. Take **_side bar_** parts out to **_sideabar.php_** file.
4. You must include the new created files to index.php
5. We are going to make the contents dynamically, so we only need a first post part.

(※ Though the instructor said to delete it, I decided to left the **_pager_** part.)
