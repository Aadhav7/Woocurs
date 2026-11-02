<?php
require_once 'config.php';
$pageTitle = 'Add Entry';
$errors = [];
$name = $email = $phone = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $phone = trim((string)($_POST['phone'] ?? ''));
    if (mb_strlen($name) < 3 || mb_strlen($name) > 100) $errors[] = 'Name must contain 3–100 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!preg_match('/^[0-9]{7,15}$/', $phone)) $errors[] = 'Phone must contain 7–15 digits only.';
    if (!$errors) {
        try {
            $stmt = $conn->prepare('INSERT INTO entries (name, email, phone) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $name, $email, $phone);
            $stmt->execute();
            flash('success', 'Entry added successfully.');
            header('Location: view.php'); exit;
        } catch (mysqli_sql_exception $ex) {
            $errors[] = $ex->getCode() === 1062 ? 'That email address is already in use.' : 'Could not save the entry. Please try again.';
        }
    }
}
require 'header.php';
?>
<div class="row justify-content-center"><div class="col-lg-8 col-xl-7">
  <div class="page-heading mb-4"><div><p class="eyebrow">CREATE · DAY 2 SUPPORT</p><h1 class="h2 mb-1">Add a new entry</h1><p class="text-secondary mb-0">Register a person in the entries database.</p></div></div>
  <?php if ($errors): ?><div class="alert alert-danger"><strong>Please correct these items:</strong><ul class="mb-0 mt-2"><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
  <div class="card app-card"><div class="card-body p-4 p-lg-5">
    <form method="post" id="entryForm" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <div class="mb-3"><label for="name" class="form-label">Full name</label><input type="text" class="form-control" id="name" name="name" minlength="3" maxlength="100" required autocomplete="name" value="<?= e($name) ?>" placeholder="Enter full name"><div class="form-text" id="nameHelp">At least 3 characters. Name changes to uppercase as you type.</div><div class="invalid-feedback">Please enter at least 3 characters.</div></div>
      <div class="mb-3"><label for="email" class="form-label">Email address</label><input type="email" class="form-control" id="email" name="email" required maxlength="190" autocomplete="email" value="<?= e($email) ?>" placeholder="name@example.com"><div class="invalid-feedback">Please enter a valid email address.</div></div>
      <div class="mb-4"><label for="phone" class="form-label">Phone number</label><input type="text" class="form-control" id="phone" name="phone" inputmode="numeric" minlength="7" maxlength="15" required value="<?= e($phone) ?>" placeholder="0771234567"><div class="form-text">Numbers only, 7–15 digits.</div><div class="invalid-feedback">Enter 7–15 digits.</div></div>
      <div class="d-flex flex-wrap gap-2"><button type="submit" class="btn btn-primary px-4">Save entry</button><a href="view.php" class="btn btn-outline-secondary">Cancel</a></div>
    </form>
  </div></div>
</div></div>
<?php require 'footer.php'; ?>
