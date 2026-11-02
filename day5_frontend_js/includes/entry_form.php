<?php
/*
 * Shared form for Add (register.php) and Update (update.php).
 * Expects: $action, $submitLabel, $name, $email, $phone, $errors
 */
?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Please fix the following:</strong>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?= e($action) ?>" id="entryForm" novalidate>
    <!-- Name: auto-uppercase while typing (PDF) -->
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" class="form-control"
               value="<?= e($name) ?>" maxlength="100"
               oninput="this.value = this.value.toUpperCase()">
        <div class="form-text">At least 3 characters. Saved in uppercase.</div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control"
               value="<?= e($email) ?>" maxlength="150">
    </div>

    <!-- Phone: input mask, numbers only (PDF) -->
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control"
               value="<?= e($phone) ?>" maxlength="15" inputmode="numeric"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        <div class="form-text">Numbers only (7 to 15 digits).</div>
    </div>

    <button type="submit" class="btn btn-success"><?= e($submitLabel) ?></button>
    <a href="view.php" class="btn btn-secondary">Cancel</a>
</form>

<script>
// Real-time validation (PDF): red border under 3 characters, green from 3 characters.
document.getElementById("name").addEventListener("input", function () {
    let name = this.value;
    if (name.length < 3) {
        this.style.borderColor = "red";
    } else {
        this.style.borderColor = "green";
    }
});
</script>
