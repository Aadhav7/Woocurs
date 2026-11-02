<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); header('Allow: POST'); exit('Method not allowed.'); }
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { flash('danger', 'Invalid entry ID.'); header('Location: view.php'); exit; }
$stmt = $conn->prepare('DELETE FROM entries WHERE id = ?');
$stmt->bind_param('i', $id); $stmt->execute();
if ($stmt->affected_rows > 0) flash('success', 'Entry deleted successfully.'); else flash('warning', 'Entry was not found or had already been deleted.');
header('Location: view.php'); exit;
