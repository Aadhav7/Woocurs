-- Day 2: MySQL database setup
-- Run this in phpMyAdmin (SQL tab) or from the terminal:
--   mysql -u root -p < database.sql

CREATE DATABASE IF NOT EXISTS woocurs_internship_db;
USE woocurs_internship_db;

CREATE TABLE IF NOT EXISTS entries (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Mini task check: confirm the table is there and empty
-- SELECT * FROM entries;
