CREATE DATABASE ebs;

CREATE USER 'ebs'@'%' IDENTIFIED BY 'ebs';

GRANT ALL PRIVILEGES ON ebs.* to 'ebs'@'%';

FLUSH PRIVILEGES;

use ebs;

CREATE TABLE users (
    id MEDIUMINT NOT NULL AUTO_INCREMENT,
    username CHAR(30) NOT NULL UNIQUE,
    password CHAR(100) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO users (username, password) values ('admin', 'password');

CREATE TABLE messages (
    id MEDIUMINT NOT NULL AUTO_INCREMENT,
    `date` DATETIME NOT NULL DEFAULT NOW(),
    `from` TINYTEXT NOT NULL,
    message TEXT NOT NULL,
    PRIMARY KEY (id)
);
