
<?php
include '../includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Xử lý form đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = mysqli_connect("localhost", "root", "", "webbanhang");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Lấy thông tin user từ database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Lưu email và tên vào session
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user['name']; 
            if($user['role']=='admin'){
                header("Location:admin.php");
            }else{

                header("Location: ../../index.php");
            }
            exit();
        }
    }
    $error = "Email hoặc mật khẩu không đúng!";
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>


    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h1 class="text-center">Đăng Nhập</h1>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                </form>
                <p class="text-center">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
            </div>
        </div>
    </main>

<?php include '../../footer.php'; ?>
</body>
</html>

