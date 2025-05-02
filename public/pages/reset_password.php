<?php
session_start();
require_once "../includes/Database.php";

define('BASE_URL', 'http://localhost/TKHTPM_NhomNKT_WebMarket/');
$page_title = 'Đặt Lại Mật Khẩu';

$conn = new mysqli("localhost", "root", "", "webbanhang");
if ($conn->connect_error) {
    $error = "Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.";
}

$error = "";
$success = "";
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

if (empty($token)) {
    $error = "Liên kết không hợp lệ!";
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (strlen($password) < 6) {
            $error = "Mật khẩu phải có ít nhất 6 ký tự!";
        } elseif ($password !== $confirm_password) {
            $error = "Mật khẩu xác nhận không khớp!";
        } else {
            // Kiểm tra token
            $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND created_at > NOW() - INTERVAL 1 HOUR");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];

                // Hash mật khẩu mới
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Cập nhật mật khẩu
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->bind_param("ss", $hashed_password, $email);
                if ($stmt->execute()) {
                    // Xóa token sau khi sử dụng
                    $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                    $stmt->bind_param("s", $token);
                    $stmt->execute();

                    $success = "Mật khẩu đã được đặt lại thành công! Vui lòng đăng nhập.";
                } else {
                    $error = "Lỗi khi cập nhật mật khẩu. Vui lòng thử lại!";
                }
            } else {
                $error = "Liên kết không hợp lệ hoặc đã hết hạn!";
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .reset-container { max-width: 500px; margin: auto; padding: 2rem; }
        .error-message { color: red; text-align: center; margin-bottom: 1rem; }
        .success-message { color: green; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="reset-container mt-5">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Đặt Lại Mật Khẩu</h1>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?> <a href="login.php">Đăng nhập ngay</a></div>
        <?php else: ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="password" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Đặt Lại Mật Khẩu</button>
                <p class="text-center text-gray-600">
                    <a href="login.php" class="text-indigo-600 hover:underline">Quay lại đăng nhập</a>
                </p>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>