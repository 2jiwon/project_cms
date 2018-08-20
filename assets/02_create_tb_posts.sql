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
  ,post_status VARCHAR(255) NOT NULL default 'draft'
  ,post_view_count INT(11) DEFAULT 0
);
