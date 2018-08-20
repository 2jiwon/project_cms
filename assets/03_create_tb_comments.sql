CREATE TABLE comments (
  comment_id INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY
  ,comment_post_id INT(3) NOT NULL
  ,comment_author VARCHAR(255) NOT NULL
  ,comment_email VARCHAR(255) NOT NULL
  ,comment_content TEXT
  ,comment_status VARCHAR(255) NOT NULL default 'Unapproved'
  ,comment_date DATETIME NOT NULL
);

