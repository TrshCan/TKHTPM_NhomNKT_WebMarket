<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('BASE_URL', 'http://localhost/TKHTPM_NhomNKT_WebMarket/');
$page_title = 'Đăng Nhập';

$conn = new mysqli("localhost", "root", "", "webbanhang");
if ($conn->connect_error) {
    $error = "Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau.";
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] == 'admin') {
                    $_SESSION['admin_id']=$user['user_id'];
                    header("Location: dashboard.php");

                } else {
                    header("Location: " . BASE_URL . "index.php");
                    exit();
                }
                exit();
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
            }
        } else {
            $error = "Email hoặc mật khẩu không đúng!";
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
    <title>Đăng Nhập</title>
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

        .login-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 400px;
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
    <div class="login-container">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Đăng Nhập</h1>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Đăng Nhập</button>
            <p class="text-center text-gray-600">
                <a href="forgot_password.php" class="text-indigo-600 hover:underline">Quên mật khẩu?</a>
            </p>
            <p class="text-center text-gray-600">Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>public/pages/register.php" class="text-indigo-600 hover:underline">Đăng Ký</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>