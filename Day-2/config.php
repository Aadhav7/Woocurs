<?php
// Database connection settings (XAMPP defaults).
// Change these if your MySQL user, password or database name is different.
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "woocurs_internship_db";

// Create connection. On PHP 8+ a failed connection throws an exception,
// so catch it and show a readable message.
try {
    $conn = new mysqli($servername, $username, $password, $database);
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Use UTF-8 so names with accents or other special characters are stored correctly
$conn->set_charset("utf8mb4");

// This file deliberately has no closing PHP tag: stray whitespace after one can break later header() calls.
