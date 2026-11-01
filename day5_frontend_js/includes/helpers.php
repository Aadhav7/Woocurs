<?php
// Shared helper functions used by every page.

// Escape text before printing it in HTML.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Server-side validation for name, email and phone (the JavaScript checks are a convenience;
// this is what actually protects the database). Returns a list of messages. Empty list = valid.
function validateEntry($name, $email, $phone)
{
    $errors = [];

    if ($name === '' || $email === '' || $phone === '') {
        $errors[] = 'All fields are required!';
    }
    if ($name !== '' && mb_strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters long.';
    }
    if (mb_strlen($name) > 100) {
        $errors[] = 'Name must be 100 characters or fewer.';
    }
    if ($email !== '' && (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150)) {
        $errors[] = 'Enter a valid email address.';
    }
    if ($phone !== '' && !preg_match('/^[0-9]{7,15}$/', $phone)) {
        $errors[] = 'Phone must contain numbers only (7 to 15 digits).';
    }

    return $errors;
}

// Message shown after a redirect (view.php?msg=...). Returns [bootstrap class, text] or null.
function flashAlert($msg)
{
    $messages = [
        'added'    => ['success', 'Entry submitted successfully!'],
        'updated'  => ['success', 'Entry updated successfully!'],
        'deleted'  => ['success', 'Entry deleted successfully!'],
        'notfound' => ['warning', 'Entry not found.'],
    ];

    return $messages[$msg] ?? null;
}
