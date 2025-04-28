<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('BASE_URL', 'http://localhost/TKHTPM_NhomNKT_WebMarket/');
$page_title = 'Đăng Ký';

function checkRegister($name, $email, $phone, $address, $password) {
    $conn = new mysqli("localhost", "root", "", "webbanhang");
    if ($conn->connect_error) {
        return "Kết nối thất bại. Vui lòng thử lại sau.";
    }

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Email không hợp lệ!";
    }
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        return "Số điện thoại phải có 10 chữ số!";
    }
    if (strlen($password) < 8) {
        return "Mật khẩu phải có ít nhất 8 ký tự!";
    }

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return "Email đã tồn tại!";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $address, $password_hash);
    $success = $stmt->execute();

    $stmt->close();
    $conn->close();
    return $success ? "" : "Đăng ký thất bại. Vui lòng thử lại.";
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $displayName = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];

    $error = checkRegister($displayName, $email, $phone, $address, $password);
    if ($error == "") {
        $_SESSION['registration_success'] = true;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
        }
        .form-control {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }
        .btn-primary {
            background-color: #6366f1;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #4f46e5;
        }
        .error-message {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .form-label {
            font-weight: 500;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Đăng Ký</h1>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="name" class="form-label">Tên hiển thị</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Đăng Ký</button>
            <p class="text-center text-gray-600">Đã có tài khoản? <a href="<?php echo BASE_URL; ?>public/pages/login.php" class="text-indigo-600 hover:underline">Đăng Nhập</a></p>
        </form>
    </div>

    <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Đăng ký thành công!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn đã đăng ký thành công. Bạn sẽ được chuyển đến trang đăng nhập.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo BASE_URL; ?>public/pages/login.php'">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    </script>
    <?php unset($_SESSION['registration_success']); ?>
    <?php endif; ?>
</body>
</html>