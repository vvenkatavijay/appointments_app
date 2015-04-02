USE red_belt;

DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS users;


CREATE TABLE users (
 id INTEGER PRIMARY KEY AUTO_INCREMENT,
 email VARCHAR(60) NOT NULL,
 user_name VARCHAR(60) NOT NULL,
 password VARCHAR(128) NOT NULL,
 date_of_birth VARCHAR(45) NOT NULL,
 created_at DATETIME
);

CREATE TABLE appointments (
 id INTEGER PRIMARY KEY AUTO_INCREMENT,
 user_id INTEGER NOT NULL,
 name VARCHAR(60) NOT NULL,
 time DATETIME,
 created_at DATETIME,
 FOREIGN KEY appointments(user_id) REFERENCES users(id)
);

/*
CREATE TABLE authors (
 id INTEGER PRIMARY KEY AUTO_INCREMENT,
 name VARCHAR(60) NOT NULL,
 created_at DATETIME
 );
 
CREATE TABLE books (
 id INTEGER PRIMARY KEY AUTO_INCREMENT,
 name VARCHAR(60) NOT NULL,
 author_id INTEGER NOT NULL,
 created_at DATETIME,
 FOREIGN KEY books(author_id) REFERENCES authors(id)
);

CREATE TABLE reviews (
 id INTEGER PRIMARY KEY AUTO_INCREMENT,
 user_id INTEGER NOT NULL,
 books_id INTEGER NOT NULL,
 rating INTEGER NOT NULL,
 description VARCHAR(200),
 created_at DATETIME,
 CONSTRAINT books_fk FOREIGN KEY reviews(user_id) REFERENCES users(id),
 CONSTRAINT books_id FOREIGN KEY reviews(books_id) REFERENCES books(id)
);
*/