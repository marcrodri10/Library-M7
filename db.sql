-- Active: 1702401604515@@127.0.0.1@3306@library
CREATE DATABASE library;
USE library;


GRANT ALL PRIVILEGES ON LIBRARY.* TO 'Library'@'localhost';


CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL
)

CREATE TABLE Readers (
    user_id INT NOT NULL,
    CONSTRAINT fk_readers_users FOREIGN KEY (user_id) REFERENCES Users(user_id)
)

CREATE TABLE Librarians (
    user_id INT NOT NULL,
    CONSTRAINT fk_librarians_users FOREIGN KEY (user_id) REFERENCES Users(user_id)
)

CREATE TABLE Admins (
    user_id INT NOT NULL,
    CONSTRAINT fk_admins_users FOREIGN KEY (user_id) REFERENCES Users(user_id)
)

CREATE TABLE Books (
    book_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    available TINYINT(1) NOT NULL,
    price FLOAT NOT NULL
)

CREATE TABLE History (
    history_id INT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    CONSTRAINT fk_history_users FOREIGN KEY (user_id) REFERENCES Users(user_id),
    CONSTRAINT fk_history_book FOREIGN KEY (book_id) REFERENCES Books(book_id)
)

CREATE TABLE Payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    amount INT NOT NULL,
    date DATE NOT NULL,
    CONSTRAINT fk_payment_users FOREIGN KEY (user_id) REFERENCES Users(user_id)
)


CREATE TABLE Suscriptions (
    suscription_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    finish_date DATE NOT NULL,
    is_active TINYINT NOT NULL,
    CONSTRAINT fk_suscription_users FOREIGN KEY (user_id) REFERENCES Users(user_id)
)

INSERT INTO Books (book_id, title, author, genre, available, price) VALUES
(1, 'El señor de los anillos', 'J.R.R. Tolkien', 'Fantasía', 1, 29.99),
(2, 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 1, 24.99),
(3, '1984', 'George Orwell', 'Ciencia ficción', 1, 19.99),
(4, 'Orgullo y prejuicio', 'Jane Austen', 'Romance', 1, 14.99),
(5, 'Código Da Vinci', 'Dan Brown', 'Misterio', 1, 27.99),
(6, 'Harry Potter y la piedra filosofal', 'J.K. Rowling', 'Fantasía', 1, 22.99),
(7, 'Matar a un ruiseñor', 'Harper Lee', 'Drama', 1, 18.99),
(8, 'Crónicas de Narnia', 'C.S. Lewis', 'Fantasía', 1, 26.99),
(9, 'Juego de tronos', 'George R.R. Martin', 'Fantasía', 1, 32.99),
(10, 'El hobbit', 'J.R.R. Tolkien', 'Fantasía', 1, 21.99);