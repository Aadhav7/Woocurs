<?php
// Database connection used by view.php (PDF: include 'config.php').
// XAMPP defaults: user "root" with an empty password.
// Change these four values if your MySQL login or database name is different.
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'woocurs_day3';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
