CREATE DATABASE LIBRARY;
USE LIBRARY

CREATE TABLE USERS (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL
)

CREATE TABLE READERS (
    user_id INT NOT NULL,
    CONSTRAINT fk_readers_users FOREIGN KEY (user_id) REFERENCES users(user_id)
)

CREATE TABLE LIBRARIANS (
    user_id INT NOT NULL,
    CONSTRAINT fk_librarians_users FOREIGN KEY (user_id) REFERENCES users(user_id)
)

CREATE TABLE ADMINS (
    user_id INT NOT NULL,
    CONSTRAINT fk_admins_users FOREIGN KEY (user_id) REFERENCES users(user_id)
)

CREATE TABLE BOOKS (
    book_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    available TINYINT(1) NOT NULL,
    price FLOAT NOT NULL
)

CREATE TABLE HISTORY (
    history_id INT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    CONSTRAINT fk_history_users FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT fk_history_book FOREIGN KEY (book_id) REFERENCES books(book_id)
)

CREATE TABLE PAYMENTS (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    amount INT NOT NULL,
    date DATE NOT NULL,
    CONSTRAINT fk_payment_users FOREIGN KEY (user_id) REFERENCES users(user_id)
)


CREATE TABLE SUSCRIPTIONS (
    suscription_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    finish_date DATE NOT NULL,
    is_active TINYINT NOT NULL,
    CONSTRAINT fk_suscription_users FOREIGN KEY (user_id) REFERENCES users(user_id)
)