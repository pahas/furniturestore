необходимо создать две таблицы:

CREATE table users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(50) NOT NULL,
password VARCHAR(255) NOT NULL,
verified BOOLEAN DEFAULT FALSE
);

CREATE TABLE items (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
description TEXT NOT NULL,
photo VARCHAR(255) NOT NULL,
price DECIMAL(10, 2) NOT NULL,
email VARCHAR(255) NOT NULL
);
