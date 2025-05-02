<?php
session_start();
require_once "../includes/Database.php";
require_once "../../vendor/autoload.php"; // Yêu cầu PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('BASE_URL', 'http://localhost/TKHTPM_NhomNKT_WebMarket/');
$page_title = 'Quên Mật Khẩu';

$conn = new mysqli("localhost", "root", "", "webbanhang");
if ($conn->connect_error) {
    $error = "Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.";
}

$error = "";
$success = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    } else {
        // Kiểm tra email tồn tại
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Tạo token
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Lưu token vào bảng password_resets
            $stmt = $conn->prepare("
                INSERT INTO password_resets (email, token, created_at)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE token = ?, created_at = ?
            ");
            $stmt->bind_param("sssss", $email, $token, $expires_at, $token, $expires_at);
            if ($stmt->execute()) {
                // Gửi email
                $mail = new PHPMailer(true);
                try {
                    // Cấu hình SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kaitokip86@gmail.com'; // Thay bằng email Gmail của bạn
                    $mail->Password = 'bizi iexm hgqh dftx'; // Thay bằng App Password của Gmail
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->CharSet = 'UTF-8';
                    // Người gửi và người nhận
                    $mail->setFrom('your-email@gmail.com', 'NKT Group');
                    $mail->addAddress($email);

                    // Nội dung email
                    $reset_link = BASE_URL . "public/pages/reset_password.php?token=" . urlencode($token);
                    $mail->isHTML(true);
                    $mail->Subject = '=?UTF-8?B?' . base64_encode('Đặt Lại Mật Khẩu') . '?=';
                    $mail->Body = "
                        <h2>Yêu cầu đặt lại mật khẩu</h2>
                        <p>Vui lòng nhấp vào liên kết dưới đây để đặt lại mật khẩu của bạn:</p>
                        <p><a href='$reset_link'>$reset_link</a></p>
                        <p>Liên kết này sẽ hết hạn sau 1 giờ.</p>
                    ";
                    $mail->AltBody = "Vui lòng truy cập $reset_link để đặt lại mật khẩu. Liên kết hết hạn sau 1 giờ.";

                    $mail->send();
                    $success = "Một liên kết đặt lại mật khẩu đã được gửi đến email của bạn!";
                } catch (Exception $e) {
                    $error = "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
                }
            } else {
                $error = "Lỗi khi xử lý yêu cầu. Vui lòng thử lại!";
            }
        } else {
            $error = "Email không tồn tại trong hệ thống!";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .forgot-container { max-width: 500px; margin: auto; padding: 2rem; }
        .error-message { color: red; text-align: center; margin-bottom: 1rem; }
        .success-message { color: green; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="forgot-container mt-5">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Quên Mật Khẩu</h1>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Gửi Liên Kết Đặt Lại</button>
            <p class="text-center text-gray-600">
                <a href="login.php" class="text-indigo-600 hover:underline">Quay lại đăng nhập</a>
            </p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>