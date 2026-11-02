<?php
// Edit Entry: loads one entry, shows the same form as Add, and saves changes.
require __DIR__ . '/config.php';
require_once __DIR__ . '/includes/helpers.php';

// The id comes from the Edit button, e.g. update.php?id=5
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: view.php?msg=notfound');
    exit;
}

$stmt = $conn->prepare('SELECT id, name, email, phone FROM entries WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$entry = $stmt->get_result()->fetch_assoc();

if (!$entry) {
    header('Location: view.php?msg=notfound');
    exit;
}

$errors = [];
$name  = $entry['name'];
$email = $entry['email'];
$phone = $entry['phone'];

if (isset($_POST['update'])) {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $errors = validateEntry($name, $email, $phone);

    if (empty($errors)) {
        $upperName = mb_strtoupper($name);
        $stmt = $conn->prepare('UPDATE entries SET name = ?, email = ?, phone = ? WHERE id = ?');
        $stmt->bind_param('sssi', $upperName, $email, $phone, $id);
        $stmt->execute();

        header('Location: view.php?msg=updated');
        exit;
    }
}

$action      = 'update.php?id=' . $id;
$submitLabel = 'Update Entry';
$pageTitle   = 'Edit Entry';

require __DIR__ . '/includes/header.php';
?>
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-4">Update Entry #<?= (int) $id ?></h4>
                <?php require __DIR__ . '/includes/entry_form.php'; ?>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
