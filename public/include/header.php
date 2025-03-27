<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .logo {
            width: 150px;
            height: 50px;
            background-color: #007bff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <a href="../../index.php" class="logo">NKT</a>
                
                <ul class="nav">
                    <li><a href="cart.php" class="nav-link px-2 link-secondary">Giỏ Hàng</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-2 link-secondary" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['name'] ?? 'Tài Khoản'); ?>
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="accountDropdown">
                            <?php if (!empty($_SESSION['name'])): ?>
                                <li><a class="dropdown-item" href="../pages/logout.php">Đăng Xuất</a></li>
                                <li><a class="dropdown-item" href="../pages/account.php">Quản lí tài khoản</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="../pages/login.php">Đăng Nhập</a></li>
                                <li><a class="dropdown-item" href="../pages/register.php">Đăng Ký</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
                
                <form action="search.php" method="get" class="d-flex">
                    <input type="search" name="query" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..." aria-label="Tìm kiếm">
                    <button class="btn btn-outline-success" type="submit">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </header>
</body>
</html>

