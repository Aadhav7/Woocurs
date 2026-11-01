-- Day 4: Update and delete entries (PHP + MySQL CRUD)
-- Import this file in phpMyAdmin (Import tab) or run: mysql -u root < database.sql
-- It creates the database, the entries table and six sample rows.
-- Importing again resets the table to these sample rows.

CREATE DATABASE IF NOT EXISTS woocurs_day4 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE woocurs_day4;

DROP TABLE IF EXISTS entries;
CREATE TABLE entries (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    phone      VARCHAR(20)  NOT NULL,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO entries (name, email, phone) VALUES
('Arun Kumar',       'arun@example.com',       '0771234567'),
('Karthik Raj',      'karthik@example.com',    '0712345678'),
('Kavitha Devi',     'kavitha@example.com',    '0763456789'),
('Suresh Kumar',     'suresh@example.com',     '0754567890'),
('Tharshini Selvam', 'tharshini@example.com',  '0705678901'),
('Ishwarya Raj',     'ishwarya@example.com',   '0786789012');
