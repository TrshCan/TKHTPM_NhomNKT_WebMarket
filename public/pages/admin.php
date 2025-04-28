<?php
session_start();
require_once "../includes/Database.php";
require_once "../includes/Admin_Database.php";
$adminDB = new Admin_Database();
$users = $adminDB->getAllUser();

// Xử lý thêm, cập nhật hoặc xóa người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($user_id) {
        $adminDB->updateUser($user_id, $name, $email, $password, $phone, $address);
    } else {
        $adminDB->addUser($name, $email, $password, $phone, $address);
    }
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
    <title>Quản lý người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center mb-4">Danh sách người dùng</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $values): ?>
            <tr>
                <td><?php echo $values['user_id']; ?></td>
                <td><?php echo $values['name']; ?></td>
                <td><?php echo $values['email']; ?></td>
                <td><?php echo $values['password']; ?></td>
                <td><?php echo $values['phone']; ?></td>
                <td><?php echo $values['address']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editUser('<?php echo $values['user_id']; ?>', '<?php echo $values['name']; ?>', '<?php echo $values['email']; ?>', '<?php echo $values['password']; ?>', '<?php echo $values['phone']; ?>', '<?php echo $values['address']; ?>')">Sửa</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo $values['user_id']; ?>')">Xóa</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Thêm người dùng</button>
    
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thêm người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="mb-3">
                            <label class="form-label">Tên</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
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
        if (confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
            window.location.href = 'admin.php?delete=' + userId;
        }
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>