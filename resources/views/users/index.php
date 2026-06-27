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
        <a href="#" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    <!-- Search box -->
    <div class="row mb-3">
        <div class="col-md-6 col-lg-4">
            <div class="input-group search-box">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search users..." aria-label="Search">
            </div>
        </div>
    </div>

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
                <!-- Sample row 1 -->
                <tr>
                    <td>
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=0D6EFD&color=fff&size=40"
                             alt="John Doe"
                             class="user-photo"
                             loading="lazy">
                    </td>
                    <td>John Doe</td>
                    <td>johndoe</td>
                    <td>john@example.com</td>
                    <td>+1 555-0100</td>
                    <td>Admin</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>2026-06-27 10:30 AM</td>
                    <td class="text-center table-actions">
                        <a href="#" class="btn btn-sm btn-outline-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger" title="Deactivate">
                            <i class="fas fa-ban"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <!-- Sample row 2 -->
                <tr>
                    <td>
                        <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=198754&color=fff&size=40"
                             alt="Jane Smith"
                             class="user-photo"
                             loading="lazy">
                    </td>
                    <td>Jane Smith</td>
                    <td>janesmith</td>
                    <td>jane@example.com</td>
                    <td>+1 555-0101</td>
                    <td>Manager</td>
                    <td><span class="badge bg-success">Active</span></td>
                    <td>2026-06-26 08:15 AM</td>
                    <td class="text-center table-actions">
                        <a href="#" class="btn btn-sm btn-outline-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger" title="Deactivate">
                            <i class="fas fa-ban"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <!-- Sample row 3 (inactive) -->
                <tr>
                    <td>
                        <img src="https://ui-avatars.com/api/?name=Bob+Johnson&background=DC3545&color=fff&size=40"
                             alt="Bob Johnson"
                             class="user-photo"
                             loading="lazy">
                    </td>
                    <td>Bob Johnson</td>
                    <td>bjohnson</td>
                    <td>bob@example.com</td>
                    <td>+1 555-0102</td>
                    <td>Staff</td>
                    <td><span class="badge bg-secondary">Inactive</span></td>
                    <td>2026-06-20 02:45 PM</td>
                    <td class="text-center table-actions">
                        <a href="#" class="btn btn-sm btn-outline-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-success" title="Activate">
                            <i class="fas fa-check-circle"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-danger" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination placeholder -->
    <nav aria-label="Page navigation" class="pagination-placeholder">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Bootstrap JS bundle (optional for toggles etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
