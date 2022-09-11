CREATE DATABASE BAsCodeTests;

DROP TABLE users;
DROP TABLE threads;
DROP TABLE posts;
DROP TABLE news;
DROP TABLE categories_tutorials;
DROP TABLE categories;
DROP TABLE tutorials;


CREATE TABLE users(
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password TEXT
);

CREATE TABLE threads (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    user_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    content VARCHAR(255),
    date DATETIME,
    user_id INTEGER,
    thread_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES threads(id) ON DELETE CASCADE

);

CREATE TABLE news (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255),
    avatar VARCHAR(255),
    date DATETIME,
    content TEXT,
    user_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
);

CREATE TABLE tutorials (
    id INTEGER PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
    name VARCHAR(255),
    date DATETIME,
    content TEXT,
    user_id INTEGER,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
    name VARCHAR(255),
    slug VARCHAR(255),
);

CREATE TABLE categories_tutorials (
    category_id INTEGER,
    tutorial_id INTEGER,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    FOREIGN KEY (tutorial_id) REFERENCES tutorials(id) ON DELETE CASCADE
);

INSERT INTO threads (name, slug) VALUES ('Demo', 'demo');

INSERT INTO posts (name, thread_id) VALUES 
('Test', 1),
('Salut', 1),
('Hello', 1)

SELECT COUNT(id) FROM posts

SELECT m.* FROM messages 
JOIN posts ON post_id = posts(id)
 