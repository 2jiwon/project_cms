CREATE TABLE users (
  user_id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY
  ,user_name VARCHAR(255) NOT NULL
  ,user_password VARCHAR(255) NOT NULL
  ,user_firstname VARCHAR(255) NOT NULL
  ,user_lastname VARCHAR(255) NOT NULL
  ,user_email VARCHAR(255) NOT NULL 
  ,user_image TEXT 
  ,user_role VARCHAR(255) NOT NULL 
  ,randSalt VARCHAR(255) 
);

