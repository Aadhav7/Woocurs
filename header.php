<?php
$pageTitle = $pageTitle ?? 'Woocurs Entries';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | Woocurs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="view.php">Woocurs <span class="text-info">Entries</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="mainNav">
      <div class="navbar-nav ms-auto">
        <a class="nav-link <?= $currentPage === 'view.php' ? 'active' : '' ?>" href="view.php">View Entries</a>
        <a class="nav-link <?= $currentPage === 'create.php' ? 'active' : '' ?>" href="create.php">Add Entry</a>
      </div>
    </div>
  </div>
</nav>
<main class="container py-4 py-lg-5">
<?php show_flash(); ?>
