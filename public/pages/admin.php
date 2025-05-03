<?php
session_start();
require_once "../includes/Database.php";
require_once "../includes/Admin_Database.php";
$adminDB = new Admin_Database();
$users = $adminDB->getAllUser();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $user_id ? $adminDB->updateUser($user_id, $name, $email, $password, $phone, $address) 
             : $adminDB->addUser($name, $email, $password, $phone, $address);
    
    header("Location: admin.php");
    exit();
}

if (isset($_GET['delete'])) {
    $adminDB->deleteUser($_GET['delete']);
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
        }
        .main-content {
            padding: 2rem;
            flex-grow: 1;
        }
        .main-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1.5rem;
        }
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .card.bg-primary {
            background-color: #3b82f6 !important;
        }
        .card.bg-success {
            background-color: #059669 !important;
        }
        .card.bg-info {
            background-color: #0ea5e9 !important;
        }
        .card.bg-warning {
            background-color: #f59e0b !important;
        }
        .table {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #3b82f6;
            color: #ffffff;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 1rem;
        }
        .btn-primary {
            background-color: #3b82f6;
            border: none;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #1e40af;
        }
        .btn-outline-secondary {
            border-radius: 0.5rem;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            .main-content h1 {
                font-size: 1.5rem;
            }
            .card {
                margin-bottom: 1rem;
            }
            .table th, .table td {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <button class="btn btn-primary d-md-none mb-3" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h2 class="mb-3">Danh sách người dùng</h2>
            
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark sticky-top">
                        <tr>
                            <th>ID</th><th>Tên</th><th>Email</th><th>Password</th><th>Phone</th><th>Address</th><th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['user_id']) ?></td>
                            <td><?= htmlspecialchars($u['name']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars(substr($u['password'], 0, 6)) ?>...</td>
                            <td><?= htmlspecialchars($u['phone']) ?></td>
                            <td><?= htmlspecialchars($u['address']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editUser('<?= htmlspecialchars($u['user_id']) ?>', '<?= addslashes(htmlspecialchars($u['name'])) ?>', '<?= htmlspecialchars($u['email']) ?>', '<?= htmlspecialchars($u['password']) ?>', '<?= htmlspecialchars($u['phone']) ?>', '<?= addslashes(htmlspecialchars($u['address'])) ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= htmlspecialchars($u['user_id']) ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="fas fa-plus me-1"></i> Thêm người dùng
            </button>
        </main>
    </div>

    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thêm người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="mb-3">
                            <label class="form-label">Tên</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        function editUser(id, name, email, password, phone, address) {
            document.getElementById('user_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('phone').value = phone;
            document.getElementById('address').value = address;
            document.getElementById('modalTitle').innerText = 'Chỉnh sửa người dùng';
            new bootstrap.Modal(document.getElementById('userModal')).show();
        }

        function confirmDelete(userId) {
            if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
                window.location.href = 'admin.php?delete=' + userId;
            }
        }
    </script>
</body>
</html>