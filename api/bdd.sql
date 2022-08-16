CREATE TABLE post (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    author BOOLEAN NOT NULL,
    created_by VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    total_messages INT NOT NULL,
    PRIMARY KEY (id)
)

CREATE TABLE messages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    content TEXT(65000) NOT NULL,
    created_by VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
)

CREATE TABLE post_messages (
    post_id INT UNSIGNED NOT NULL,
    message_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, message_id),
    CONSTRAINT fk_post
        FOREIGN KEY(post_id)
        REFERENCES post (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,

    CONSTRAINT fk_message
        FOREIGN KEY(message_id)
        REFERENCES messages (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)


CREATE TABLE actu (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    theme_image VARCHAR(255) NOT NULL, 
    created_by VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
)

CREATE TABLE user (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)