<?php
include "../include/db.php";

function getUserInfo($email) {
    global $conn;
    
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}
?>
<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user = getUserInfo($_SESSION['email']);

if (!$user) {
    echo "<p>Lỗi: Không thể lấy thông tin tài khoản.</p>";
    exit();
}

include "../..//header.php";
?>

<main class="account-page">
    <h1 class="text-center">Thông Tin Tài Khoản</h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông Tin Cá Nhân</h5>
                        <p class="card-text">Tên: <?php echo htmlspecialchars($user['name']); ?></p>
                        <p class="card-text">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="card-text">Số điện thoại: <?php echo htmlspecialchars($user['phone']); ?></p>
                        <p class="card-text">Địa Chỉ: <?php echo htmlspecialchars($user['address']); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thao Tác</h5>
                        <p class="card-text">
                            <button class="btn btn-primary" onclick="window.location.href='../pages/orders.php'">Lịch Sử Đơn Hàng</button>
                            <button class="btn btn-secondary" onclick="window.location.href='../pages/settings.php'">Cài Đặt</button>
                            <button class="btn btn-danger logout" onclick="window.location.href='../pages/logout.php'">Đăng Xuất</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "../../footer.php"; ?>

