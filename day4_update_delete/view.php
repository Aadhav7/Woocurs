<?php
require 'config.php';

// ---- Search by name or email (Day 3) ----
$search = trim($_GET['search'] ?? '');
$like   = '%' . $search . '%';

// ---- Pagination: 5 entries per page (Day 3) ----
$perPage = 5;
$page    = max(1, (int) ($_GET['page'] ?? 1));

$countStmt = $conn->prepare('SELECT COUNT(*) AS total FROM entries WHERE name LIKE ? OR email LIKE ?');
$countStmt->bind_param('ss', $like, $like);
$countStmt->execute();
$total      = (int) $countStmt->get_result()->fetch_assoc()['total'];
$totalPages = max(1, (int) ceil($total / $perPage));
$page       = min($page, $totalPages);
$offset     = ($page - 1) * $perPage;

$stmt = $conn->prepare(
    'SELECT * FROM entries
     WHERE name LIKE ? OR email LIKE ?
     ORDER BY id DESC
     LIMIT ? OFFSET ?'
);
$stmt->bind_param('ssii', $like, $like, $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function pageLink($page, $search)
{
    return 'view.php?' . http_build_query(['search' => $search, 'page' => $page]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Entries - Woocurs Day 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <h2>All Entries</h2>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Name or Email" value="<?= e($search) ?>">
            <button class="btn btn-primary" type="submit">Search</button>
            <?php if ($search !== ''): ?>
                <a class="btn btn-outline-secondary" href="view.php">Clear</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($row['id']) ?></td>
                        <td><?= e($row['name']) ?></td>
                        <td><?= e($row['email']) ?></td>
                        <td><?= e($row['phone']) ?></td>
                        <td><?= e($row['created_at']) ?></td>
                        <td class="text-nowrap">
                            <!-- PDF: Edit goes to update.php, Delete asks for confirmation first -->
                            <a href="update.php?id=<?= e($row['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete.php?id=<?= e($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No entries found</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav class="d-flex justify-content-between align-items-center mt-3">
        <?php if ($page > 1): ?>
            <a class="btn btn-outline-primary" href="<?= e(pageLink($page - 1, $search)) ?>">&laquo; Previous</a>
        <?php else: ?>
            <span class="btn btn-outline-secondary disabled">&laquo; Previous</span>
        <?php endif; ?>

        <span class="text-secondary">Page <?= $page ?> of <?= $totalPages ?></span>

        <?php if ($page < $totalPages): ?>
            <a class="btn btn-outline-primary" href="<?= e(pageLink($page + 1, $search)) ?>">Next &raquo;</a>
        <?php else: ?>
            <span class="btn btn-outline-secondary disabled">Next &raquo;</span>
        <?php endif; ?>
    </nav>
</div>
</body>
</html>
