#DROP SCHEMA IF EXISTS `scwa`
#CREATE SCHEMA `scwa`;
#use `scwa`;

DROP TABLE IF EXISTS users, posts;

CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(45) UNIQUE NOT NULL,
       password TEXT NOT NULL,
       is_admin TINYINT DEFAULT 0
);

CREATE TABLE posts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       town TEXT NOT NULL,
       start_date DATE NOT NULL,
       end_date DATE NOT NULL,
       title TEXT NOT NULL,
       content TEXT NOT NULL,
       user_id INT REFERENCES user(id),
       show_now TINYINT DEFAULT 0,
       post_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

# CREATE TABLE FOR TOWN OR TEXTEDIT A TOWN LIST?

# -----------------------------------------------

TRUNCATE TABLE users;
TRUNCATE TABLE posts;

#INSERT INTO users
#       (username, password, is_admin)
#VALUES
#       ('sgalante', 'password', 1),
#       ('pnguyen', 'password', 1),
#       ('csievers', 'password', 0);

#INSERT INTO posts
#       (town, start_date, end_date, title, content, user_id)
#VALUE
#       ('AMAGANSETT', '1996-03-12', '1996-04-09', 'Hydrant Flow Tests', 'There will be #Water Flow Tests at....', 1);
