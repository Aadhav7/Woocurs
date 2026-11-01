<?php
// Deletes one entry. Called by the "Yes, Delete" button in the Bootstrap modal on view.php.
require __DIR__ . '/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$msg = 'notfound';

if ($id) {
    $stmt = $conn->prepare('DELETE FROM entries WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $msg = 'deleted';
    }
}

header('Location: view.php?msg=' . $msg);
exit;
