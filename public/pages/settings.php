<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include "../include/header.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['password'];

    $conn = mysqli_connect("localhost", "root", "", "webbanhang");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT password FROM users WHERE email='" . $_SESSION['email'] . "'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (!password_verify($currentPassword, $user['password'])) {
        $error = "Mật khẩu hiện tại không đúng!";
    } else {
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            $hashedPassword = $user['password'];
        }

        $sql = "UPDATE users SET name='$name', password='$hashedPassword' WHERE email='" . $_SESSION['email'] . "'";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['name'] = $name;
            header("Location:account.php");
            exit();
        } else {
            $error = "Cập nhật thất bại!";
        }
    }

    mysqli_close($conn);
}

?>

<main class="settings-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h1 class="text-center">Cài Đặt</h1>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập tên
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="current-password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="current-password" name="current-password" required>
                        <div class="invalid-feedback">
                            Vui lòng nhập mật khẩu hiện tại
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback">
                            Vui lòng nhập mật khẩu mới
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </form>

                <?php if (isset($error)): ?>
                    <p class="text-danger"><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?php include "../include/footer.php"; ?>

