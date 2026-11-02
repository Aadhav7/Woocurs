<?php
include 'config.php';

// Only handle submitted form data. If someone opens form.php directly, send them to the form.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form.html");
    exit;
}

// 1. Read and trim the input. ?? '' avoids warnings if a field is missing.
$name  = trim($_POST['name']  ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// 2. Server-side validation. JavaScript checks can be bypassed, so always check here too.
$errors = [];

if ($name === '') {
    $errors[] = "Name is required.";
} elseif (mb_strlen($name) > 100) {
    $errors[] = "Name must be 100 characters or fewer.";
}

if ($email === '') {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
} elseif (strlen($email) > 100) {
    $errors[] = "Email must be 100 characters or fewer.";
}

if ($phone === '') {
    $errors[] = "Phone is required.";
} elseif (!preg_match('/^\d{10}$/D', $phone)) {  // D: $ must match only at the very end
    $errors[] = "Phone must be exactly 10 digits.";
}

// 3. Duplicate check (prepared statement). Only runs if the basic checks passed.
if (empty($errors)) {
    $check = $conn->prepare("SELECT id FROM entries WHERE email = ? LIMIT 1");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = "Email already exists.";
    }
    $check->close();
}

// 4. Insert the entry (prepared statement protects against SQL injection).
$saved    = false;
$dbError  = false;

if (empty($errors)) {
    $stmt = $conn->prepare("INSERT INTO entries (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        $saved = true;
    } else {
        // Log the real database error for the developer, but show users a plain message.
        error_log("Insert failed: " . $stmt->error);
        $dbError = true;
        $errors[] = "Something went wrong while saving. Please try again.";
    }
    $stmt->close();
}

$conn->close();

// Status codes: 200 = saved, 400 = bad input, 500 = server/database problem
if ($saved) {
    http_response_code(200);
} elseif ($dbError) {
    http_response_code(500);
} else {
    http_response_code(400);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Result</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 420px; margin: 40px auto; padding: 0 16px; }
    .error { color: #b00020; }
    .success { color: #1b7f3b; }
    a { display: inline-block; margin-top: 16px; }
  </style>
</head>
<body>

<?php if ($saved): ?>
  <p class="success">Entry added successfully!</p>
<?php else: ?>
  <p class="error">Please fix the following:</p>
  <ul class="error">
    <?php foreach ($errors as $error): ?>
      <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

  <a href="form.html">Back to form</a>

</body>
</html>
