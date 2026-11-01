<?php
require_once __DIR__ . '/helpers.php';

$pageTitle = $pageTitle ?? 'Entries';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | Woocurs Day 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Mobile-friendly navigation (PDF: navbar-expand-lg navbar-dark bg-dark) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="view.php">Entries</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'view.php' ? 'active' : '' ?>" href="view.php">All Entries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'register.php' ? 'active' : '' ?>" href="register.php">Add Entry</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container-fluid py-4">
