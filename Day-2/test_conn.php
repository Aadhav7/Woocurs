<?php
include 'config.php';

echo "Database Connected!";

// Optional: confirm the entries table exists
$result = $conn->query("SHOW TABLES LIKE 'entries'");
if ($result && $result->num_rows > 0) {
    echo "<br>Table 'entries' found.";
} else {
    echo "<br>Table 'entries' NOT found. Run database.sql first.";
}

$conn->close();
