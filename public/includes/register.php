<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Giả sử đây là nơi xử lý đăng ký người dùng (thay thế bằng truy vấn cơ sở dữ liệu trong thực tế)
    $user_data = [
        'username' => 'sampleUser',
        'email' => 'sample@example.com',
        'password' => password_hash('samplePass', PASSWORD_DEFAULT) // Nên dùng hash mật khẩu
    ];

    // Kiểm tra nếu tên đăng nhập hoặc email đã tồn tại
    if ($username == $user_data['username'] || $email == $user_data['email']) {
        $error = "Tên đăng nhập hoặc email đã tồn tại!";
    } else {
        $_SESSION['username'] = $username;
        header("Location: index.php");
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
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<?php include "header.php" ?>

    <main class="register-page">
        <h1>Đăng Ký</h1>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng Ký</button>
        </form>
        <p>Đã có tài khoản? <a href="login.php">Đăng Nhập</a></p>
    </main>

<?php include "footer.php" ?>
</body>
</html>

