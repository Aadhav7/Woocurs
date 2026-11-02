<?php
require 'config.php';

// PDF: if (isset($_GET['id'])) { DELETE FROM entries WHERE id = ... }
// The id is checked as a whole number before it is used.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    try {
        $stmt = $conn->prepare('DELETE FROM entries WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        exit('Error deleting record: ' . htmlspecialchars($e->getMessage()));
    }
}

// PDF: redirect back to the list.
header('Location: view.php');
exit;
