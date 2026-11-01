<?php
require 'config.php';

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// The record id comes from the Edit link, e.g. update.php?id=5
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: view.php');
    exit;
}

// PDF: SELECT * FROM entries WHERE id = ... (prepared statement)
$stmt = $conn->prepare('SELECT id, name, email, phone FROM entries WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    http_response_code(404);
    exit('Entry not found. <a href="view.php">Back to entries</a>');
}

$errors = [];

// PDF: if (isset($_POST['update'])) { ... UPDATE entries ... }
if (isset($_POST['update'])) {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Server-side validation (PDF: "Check update validation", email format and phone length).
    if ($name === '' || $email === '' || $phone === '') {
        $errors[] = 'All fields are required!';
    }
    if (mb_strlen($name) > 100) {
        $errors[] = 'Name must be 100 characters or fewer.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if ($phone !== '' && (strlen($phone) < 7 || strlen($phone) > 15)) {
        $errors[] = 'Phone number must be 7 to 15 characters long.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('UPDATE entries SET name = ?, email = ?, phone = ? WHERE id = ?');
        $stmt->bind_param('sssi', $name, $email, $phone, $id);
        $stmt->execute();

        // PDF: redirect back to the list after saving.
        header('Location: view.php');
        exit;
    }

    // Validation failed: show what the user typed so they can correct it.
    $row = ['id' => $id, 'name' => $name, 'email' => $email, 'phone' => $phone];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Entry - Woocurs Day 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5" style="max-width: 720px;">
    <a href="view.php" class="btn btn-outline-secondary btn-sm mb-3">&larr; Back to entries</a>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2 class="card-title mb-4">Update Entry #<?= e($row['id']) ?></h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- PDF: method POST, action="". novalidate lets our server-side checks show their messages. -->
            <form method="POST" action="" novalidate>
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= e($row['name']) ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= e($row['email']) ?>" class="form-control">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?= e($row['phone']) ?>" class="form-control">
                </div>
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="view.php" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
