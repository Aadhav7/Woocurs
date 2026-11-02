<?php
// Entries list: search and pagination (Day 3), edit and delete buttons (Day 4),
// sorting, hover highlight, live filter, delete modal and alerts (Day 5).
require __DIR__ . '/config.php';
require_once __DIR__ . '/includes/helpers.php';

// ---- Search by name or email (server-side, works across all pages) ----
$search = trim($_GET['search'] ?? '');
$like   = '%' . $search . '%';

// ---- Pagination: 5 entries per page ----
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
    'SELECT id, name, email, phone FROM entries
     WHERE name LIKE ? OR email LIKE ?
     ORDER BY id DESC
     LIMIT ? OFFSET ?'
);
$stmt->bind_param('ssii', $like, $like, $perPage, $offset);
$stmt->execute();
$entries = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Success or warning alert after add, update or delete (view.php?msg=...)
$alert = flashAlert($_GET['msg'] ?? '');

function pageLink($page, $search)
{
    return 'view.php?' . http_build_query(['search' => $search, 'page' => $page]);
}

$pageTitle = 'All Entries';
require __DIR__ . '/includes/header.php';
?>
<div class="row">
    <div class="col-lg-12">

        <?php if ($alert): ?>
            <div class="alert alert-<?= e($alert[0]) ?> alert-dismissible fade show" role="alert">
                <?= e($alert[1]) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <h2 class="mb-0">All Entries</h2>
            <a href="register.php" class="btn btn-primary">+ Add Entry</a>
        </div>

        <!-- Search: pressing Enter or Search looks through all pages.
             Typing also hides rows on this page that do not match (live filter). -->
        <form method="GET" class="mb-2" role="search">
            <div class="input-group">
                <input type="search" id="searchBox" name="search" class="form-control"
                       placeholder="Search by Name or Email" value="<?= e($search) ?>">
                <button class="btn btn-primary" type="submit">Search</button>
                <?php if ($search !== ''): ?>
                    <a class="btn btn-outline-secondary" href="view.php">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        <p class="small text-muted mb-2">Tip: click a column heading (Name, Email, Phone) to sort.</p>

        <!-- Scrollable on small screens (PDF: table-responsive) -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle bg-white" id="entriesTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th onclick="sortTable(1)" title="Click to sort">Name</th>
                        <th onclick="sortTable(2)" title="Click to sort">Email</th>
                        <th onclick="sortTable(3)" title="Click to sort">Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($entries) > 0): ?>
                    <?php foreach ($entries as $row): ?>
                        <tr data-search="<?= e($row['name'] . ' ' . $row['email'] . ' ' . $row['phone']) ?>"
                            onmouseover="highlightRow(this, '#f2f2f2')"
                            onmouseout="highlightRow(this, '')">
                            <td><?= (int) $row['id'] ?></td>
                            <td><?= e($row['name']) ?></td>
                            <td><?= e($row['email']) ?></td>
                            <td><?= e($row['phone']) ?></td>
                            <td class="text-nowrap">
                                <a href="update.php?id=<?= (int) $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <!-- Opens the modal. The modal reads data-id and data-name from this button. -->
                                <button type="button" class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-id="<?= (int) $row['id'] ?>"
                                        data-name="<?= e($row['name']) ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No entries found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination: Previous | Page x of y | Next -->
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
</div>

<!-- Delete confirmation modal (PDF: replaces confirm()). One modal is shared by every row. -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this entry?
                <p class="mt-2 mb-0 fw-bold" id="deleteName"></p>
            </div>
            <div class="modal-footer">
                <a href="delete.php" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
// ---- 1. Sort the table by a column (PDF). n = column index: 1 Name, 2 Email, 3 Phone ----
function sortTable(n) {
    let table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("entriesTable");
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

// ---- 2. Hover highlight (PDF: onmouseover / onmouseout on each row) ----
// The colour is set on the cells, because Bootstrap's striped and hover styles sit on the cells
// and would hide a colour set only on the row.
function highlightRow(row, color) {
    Array.from(row.cells).forEach(function (cell) {
        cell.style.backgroundColor = color;
    });
}

// ---- 3. Live filter: hide rows on this page that do not match what is typed ----
document.getElementById("searchBox").addEventListener("input", function () {
    const query = this.value.trim().toLowerCase();
    document.querySelectorAll("#entriesTable tbody tr[data-search]").forEach(function (row) {
        row.style.display = row.dataset.search.toLowerCase().includes(query) ? "" : "none";
    });
});

// ---- 4. Delete modal: each row's Delete button fills in its own id and name ----
document.getElementById("deleteModal").addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;
    document.getElementById("confirmDeleteBtn").href =
        "delete.php?id=" + encodeURIComponent(button.getAttribute("data-id"));
    document.getElementById("deleteName").textContent = button.getAttribute("data-name");
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
