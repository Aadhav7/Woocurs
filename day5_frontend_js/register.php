<?php
// Add Entry: shows the registration form and saves a new entry (Day 2 form, Day 5 enhancements).
require __DIR__ . '/config.php';
require_once __DIR__ . '/includes/helpers.php';

$errors = [];
$name  = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $errors = validateEntry($name, $email, $phone);

    if (empty($errors)) {
        $upperName = mb_strtoupper($name);
        $stmt = $conn->prepare('INSERT INTO entries (name, email, phone) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $upperName, $email, $phone);
        $stmt->execute();

        // Post/Redirect/Get: refreshing the page will not insert the entry twice.
        header('Location: view.php?msg=added');
        exit;
    }
}

$action      = 'register.php';
$submitLabel = 'Submit Entry';
$pageTitle   = 'Add Entry';

require __DIR__ . '/includes/header.php';
?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-4">Add New Entry</h4>
                <?php require __DIR__ . '/includes/entry_form.php'; ?>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
