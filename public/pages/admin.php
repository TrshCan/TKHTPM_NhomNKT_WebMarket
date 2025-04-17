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
        .sidebar { min-height: 100vh; background-color: #343a40; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.75); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; }
        .sidebar .nav-link.active { background-color: rgba(255, 255, 255, 0.1); }
        .table-responsive { max-height: 70vh; overflow-y: auto; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark">
            <div class="position-sticky pt-3">
                <h4 class="text-white text-center mb-4">Admin Dashboard</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin.php"><i class="fas fa-users me-2"></i>Quản lý người dùng</a></li>
                    <li class="nav-item"><a class="nav-link" href="quanlysanpham.php"><i class="fas fa-box me-2"></i>Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php"><i class="fas fa-shopping-cart me-2"></i>Đơn hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="report.php"><i class="fas fa-chart-bar me-2"></i>Báo cáo</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
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
                            <td><?= $u['user_id'] ?></td>
                            <td><?= $u['name'] ?></td>
                            <td><?= $u['email'] ?></td>
                            <td><?= substr($u['password'], 0, 6) ?>...</td>
                            <td><?= $u['phone'] ?></td>
                            <td><?= $u['address'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editUser('<?= $u['user_id'] ?>', '<?= addslashes($u['name']) ?>', '<?= $u['email'] ?>', '<?= $u['password'] ?>', '<?= $u['phone'] ?>', '<?= addslashes($u['address']) ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $u['user_id'] ?>')">
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
        </div>
    </div>
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