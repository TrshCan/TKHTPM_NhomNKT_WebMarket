<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = 'Quản Lý Tài Khoản';

include "../../header.php";
require_once "../includes/User_Database.php";
$userDb = new User_Database();

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

// Handle password change
$error = "";
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Vui lòng điền đầy đủ các trường.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    } elseif (strlen($new_password) < 8) {
        $error = "Mật khẩu mới phải có ít nhất 8 ký tự.";
    } elseif (!password_verify($current_password, $user['password'])) {
        $error = "Mật khẩu hiện tại không đúng.";
    } else {
        // Update password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        if ($userDb->updatePassword($_SESSION['email'], $new_password_hash)) {
            $success = "Đổi mật khẩu thành công!";
        } else {
            $error = "Đổi mật khẩu thất bại. Vui lòng thử lại.";
        }
    }
}

// Fetch order history
$orders = [];
$conn = new mysqli("localhost", "root", "", "webbanhang");
if ($conn->connect_error) {
    $error = "Không thể kết nối đến cơ sở dữ liệu.";
} else {
    // Use 'total_price' as per the orders table structure
    $stmt = $conn->prepare("SELECT order_id, total_price, order_date, status FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    if (!$stmt) {
        $error = "Lỗi truy vấn cơ sở dữ liệu: " . $conn->error;
    } else {
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
        }
        .account-page {
            padding: 4rem 0;
        }
        .account-page h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 2rem;
            text-align: center;
        }
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            margin-bottom: 1.5rem;
        }
        .card-body {
            padding: 2rem;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        .card-text {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        .card-text strong {
            color: #1f2937;
        }
        .btn {
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #3b82f6;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1e40af;
        }
        .btn-secondary {
            background-color: #6b7280;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        .btn-danger {
            background-color: #ef4444;
            border: none;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        .error-message {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .success-message {
            background-color: #d1fae5;
            color: #059669;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .table {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #3b82f6;
            color: #ffffff;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 1rem;
        }
        @media (max-width: 768px) {
            .account-page h1 {
                font-size: 2rem;
            }
            .card-body {
                padding: 1.5rem;
            }
            .card-title {
                font-size: 1.25rem;
            }
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <main class="account-page">
        <h1>Quản Lý Tài Khoản</h1>
        <div class="container">
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="row justify-content-center">
                <!-- User Information -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thông Tin Cá Nhân</h5>
                            <p class="card-text"><strong>Tên:</strong> <?php echo htmlentities($user['name']); ?></p>
                            <p class="card-text"><strong>Email:</strong> <?php echo htmlentities($user['email']); ?></p>
                            <p class="card-text"><strong>Số điện thoại:</strong> <?php echo htmlentities($user['phone']); ?></p>
                            <p class="card-text"><strong>Địa chỉ:</strong> <?php echo htmlentities($user['address']); ?></p>
                        </div>
                    </div>
                </div>
                <!-- Actions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body d-grid gap-2">
                            <h5 class="card-title">Thao Tác</h5>
                            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#orderHistory" aria-expanded="false" aria-controls="orderHistory">Lịch Sử Đơn Hàng</button>
                            <button class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="settings">Cài Đặt</button>
                            <a href="../pages/logout.php" class="btn btn-danger">Đăng Xuất</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order History -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="collapse" id="orderHistory">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Lịch Sử Đơn Hàng</h5>
                                <?php if (!empty($orders)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Mã Đơn Hàng</th>
                                                    <th>Ngày Đặt</th>
                                                    <th>Tổng Tiền</th>
                                                    <th>Trạng Thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order): ?>
                                                    <tr>
                                                        <td>#<?php echo htmlspecialchars($order['order_id']); ?></td>
                                                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($order['order_date']))); ?></td>
                                                        <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?>đ</td>
                                                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-center text-gray-600">Bạn chưa có đơn hàng nào.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Settings (Change Password) -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="collapse" id="settings">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Đổi Mật Khẩu</h5>
                                <?php if (!empty($success)): ?>
                                    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                                <?php endif; ?>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Mật Khẩu Hiện Tại</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Mật Khẩu Mới</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Xác Nhận Mật Khẩu Mới</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div>
                                    <button type="submit" name="change_password" class="btn btn-primary">Đổi Mật Khẩu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "../../footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>