-- Active: 1703865360951@@127.0.0.1@3306@library

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


CREATE TABLE Subscriptions (
    suscription_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    finish_date DATE NOT NULL,
    is_active TINYINT NOT NULL,
    type VARCHAR(255) NOT NULL,
    CONSTRAINT fk_suscription_users FOREIGN KEY (user_id) REFERENCES Users(user_id)
)



CREATE TABLE Files (
    file_id INT PRIMARY KEY AUTO_INCREMENT,
    book_id INT NOT NULL,
    route VARCHAR(255),
    
    CONSTRAINT fk_files_book FOREIGN KEY (book_id) REFERENCES Books(book_id)
)

INSERT INTO FILES (book_id, route) VALUES 
    (1, 'book_1'),
    (2, 'book_2'),
    (3, 'book_3'),
    (4, 'book_4'),
    (5, 'book_5'),
    (6, 'book_6'),
    (7, 'book_7'),
    (8, 'book_8'),
    (9, 'book_9'),
    (10, 'book_10')



INSERT INTO Books (book_id, title, author, genre, available, price) VALUES
(1, 'El señor de los anillos', 'J.R.R. Tolkien', 'Fantasía', 29.99),
(2, 'Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 24.99),
(3, '1984', 'George Orwell', 'Ciencia ficción', 19.99),
(4, 'Orgullo y prejuicio', 'Jane Austen', 'Romance', 14.99),
(5, 'Código Da Vinci', 'Dan Brown', 'Misterio', 27.99),
(6, 'Harry Potter y la piedra filosofal', 'J.K. Rowling', 'Fantasía', 22.99),
(7, 'Matar a un ruiseñor', 'Harper Lee', 'Drama', 18.99),
(8, 'Crónicas de Narnia', 'C.S. Lewis', 'Fantasía', 26.99),
(9, 'Juego de tronos', 'George R.R. Martin', 'Fantasía', 32.99),
(10, 'El hobbit', 'J.R.R. Tolkien', 'Fantasía', 21.99);