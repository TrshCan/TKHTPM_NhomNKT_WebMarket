<?php
session_start();

function checkRegister($name, $email, $phone, $address, $password) {
    // Xử lý đăng ký người dùng
    $conn = new mysqli("localhost", "root", "", "webbanhang");
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return "Email đã tồn tại!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $password_hash);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute();
        return "";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $displayName = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $error = checkRegister($displayName, $email, $phone, $address, $password);
    if ($error == "") {
        $_SESSION['registration_success'] = true; // Set session variable to indicate success
        header("Location: register.php"); 
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="../assets/css/login-register.css">
</head>
<body>

<?php require_once "../includes/header.php" ?>

    <main class="register-page">
        <h1 style="margin-top: 60px;">Đăng Ký</h1>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" style="width: 100%; margin: 0 auto;">
            <div class="row">
                <div class="col-md-4">
                    <label for="name" class="form-label">Tên hiển thị</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-4">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div style="display: flex; justify-content: center;">
                        <button type="submit" class="btn btn-primary">Đăng Ký</button>
                    </div>
                    <p style="text-align: center;">Đã có tài khoản? <a href="login.php">Đăng Nhập</a></p>
                </div>
            </div>
        </form>
    </main>

<?php include "../../footer.php" ?>
<!-- Modal thông báo đăng ký thành công -->
<?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']): ?>
    <div class="modal" tabindex="-1" role="dialog" id="successModal" style="display:block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng ký thành công!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn đã đăng ký thành công. Bạn sẽ được chuyển đến trang đăng nhập.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='login.php'">OK</button>
                </div>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['registration_success']); ?>
<?php endif; ?>
</body>
</html>

