CREATE DATABASE IF NOT EXISTS woocurs_entries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE woocurs_entries;

CREATE TABLE IF NOT EXISTS entries (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_entries_name (name),
    INDEX idx_entries_email (email)
);
INSERT INTO entries (name, email, phone) SELECT 'Suriya', 'suriya@example.com', '0771234567' WHERE NOT EXISTS ( SELECT 1 FROM entries WHERE email = 'suriya@example.com' ); INSERT INTO entries (name, email, phone) SELECT 'Rajinikanth', 'rajini@example.com', '0712345678' WHERE NOT EXISTS ( SELECT 1 FROM entries WHERE email = 'rajini@example.com' ); INSERT INTO entries (name, email, phone) SELECT 'Vijay', 'vijay@example.com', '0763456789' WHERE NOT EXISTS ( SELECT 1 FROM entries WHERE email = 'vijay@example.com' ); INSERT INTO entries (name, email, phone) SELECT 'Trisha', 'trisha@example.com', '0754567890' WHERE NOT EXISTS ( SELECT 1 FROM entries WHERE email = 'trisha@example.com' ); INSERT INTO entries (name, email, phone) SELECT 'Asin', 'asin@example.com', '0705678901' WHERE NOT EXISTS ( SELECT 1 FROM entries WHERE email = 'asin@example.com' );
