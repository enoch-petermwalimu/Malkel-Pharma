<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .user-photo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        .table-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        .search-box {
            max-width: 300px;
        }
        .pagination-placeholder {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }
        .pagination-placeholder .page-item.disabled .page-link {
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h1 class="h3 mb-0">Users</h1>
        <a href="/users/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    <!-- Search box -->
    <form method="GET" action="/users" class="row mb-3">
        <div class="col-md-6 col-lg-4">
            <div class="input-group search-box">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search users..." aria-label="Search" value="<?= htmlspecialchars($search ?? '') ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <!-- Responsive table wrapper -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Photo</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Last Login</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="9" class="text-center text-muted">No users found.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php if ($user->photo): ?>
                        <img src="<?= htmlspecialchars($user->photo) ?>"
                             alt="<?= htmlspecialchars($user->full_name) ?>"
                             class="user-photo"
                             loading="lazy">
                        <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->full_name) ?>&background=0D6EFD&color=fff&size=40"
                             alt="<?= htmlspecialchars($user->full_name) ?>"
                             class="user-photo"
                             loading="lazy">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($user->full_name) ?></td>
                    <td><?= htmlspecialchars($user->username) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td><?= htmlspecialchars($user->phone ?? '') ?></td>
                    <td><?= htmlspecialchars($user->role) ?></td>
                    <td>
                        <?php if ($user->is_active): ?>
                        <span class="badge bg-success">Active</span>
                        <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $user->last_login ? date('Y-m-d h:i A', strtotime($user->last_login)) : 'Never' ?></td>
                    <td class="text-center table-actions">
                        <a href="/users/view/<?= $user->id ?>" class="btn btn-sm btn-outline-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="/users/edit/<?= $user->id ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($user->is_active): ?>
                        <a href="/users/deactivate/<?= $user->id ?>" class="btn btn-sm btn-outline-danger" title="Deactivate" onclick="return confirm('Deactivate this user?')">
                            <i class="fas fa-ban"></i>
                        </a>
                        <?php else: ?>
                        <a href="/users/activate/<?= $user->id ?>" class="btn btn-sm btn-outline-success" title="Activate" onclick="return confirm('Activate this user?')">
                            <i class="fas fa-check-circle"></i>
                        </a>
                        <?php endif; ?>
                        <a href="/users/delete/<?= $user->id ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this user?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
    <nav aria-label="Page navigation" class="pagination-placeholder">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>" tabindex="-1" aria-disabled="<?= $page <= 1 ? 'true' : 'false' ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<!-- Bootstrap JS bundle (optional for toggles etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
