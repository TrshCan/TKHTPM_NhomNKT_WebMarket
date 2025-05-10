<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Chuyển hướng đến trang chủ
    exit();
}

// Xử lý form đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Giả sử đây là dữ liệu người dùng đã đăng kí (thay thế bằng truy vấn cơ sở dữ liệu trong thực tế)
    $user_data = [
        'username' => 'sampleUser',
        'password' => 'samplePass' // Lưu ý: trong thực tế nên dùng hash mật khẩu
    ];

    // Kiểm tra thông tin đăng nhập
    if ($username == $user_data['username'] && $password == $user_data['password']) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<?php include "header.php" ?>
    <main class="login-page">
        <h1>Đăng Nhập</h1>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng Nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
    </main>

<?php include "footer.php" ?>
</body>
</html>

