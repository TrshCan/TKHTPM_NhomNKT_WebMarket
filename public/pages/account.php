<?php
require_once "../include/User_Database.php";
$userDb = new User_Database();

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user = $userDb->getUserInfo($_SESSION['email']);

if (!$user) {
    error_log("Lỗi: Không thể lấy thông tin tài khoản của " . $_SESSION['email']);
    echo "<p class='text-danger text-center'>Lỗi: Không thể lấy thông tin tài khoản.</p>";
    exit();
}

include "../include/header.php";
?>

<main class="account-page">
    <h1 class="text-center">Thông Tin Tài Khoản</h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông Tin Cá Nhân</h5>
                        <p class="card-text"><strong>Tên:</strong> <?= htmlentities($user['name']) ?></p>
                        <p class="card-text"><strong>Email:</strong> <?= htmlentities($user['email']) ?></p>
                        <p class="card-text"><strong>Số điện thoại:</strong> <?= htmlentities($user['phone']) ?></p>
                        <p class="card-text"><strong>Địa chỉ:</strong> <?= htmlentities($user['address']) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body d-grid gap-2">
                        <h5 class="card-title">Thao Tác</h5>
                        <a href="../pages/orders.php" class="btn btn-primary">Lịch Sử Đơn Hàng</a>
                        <a href="../pages/settings.php" class="btn btn-secondary">Cài Đặt</a>
                        <a href="../pages/logout.php" class="btn btn-danger">Đăng Xuất</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "../include/footer.php"; ?>
