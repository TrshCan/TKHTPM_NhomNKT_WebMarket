<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    /* Đổi màu sắc cho các thành phần */
.text-orange {
    color: #ff6600;
}

/* Tùy chỉnh nút tìm kiếm */
.btn-orange {
    background-color: #ff6600;
    border-color: #ff6600;
    color: #fff;
}

.btn-orange:hover {
    background-color: #cc5200;
    border-color: #cc5200;
}

/* Responsive styles */
@media (max-width: 768px) {
    .navbar-nav {
        text-align: center;
    }

    .search-box form {
        width: 100%;
    }

    .logo {
        text-align: center;
        margin-bottom: 10px;
    }
}

</style>
</head>

<body>
    <!-- Header -->
    <header>
    <div class="container-fluid bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <div class="logo fs-2 fw-bold">
                <span class="text-orange">N<span>K</span>T</span>
            </div>
            
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand fs-4" href="index.php">Trang Chủ</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="public/pages/cart.php">Giỏ Hàng</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo isset($_SESSION['name']) && $_SESSION['name'] !== '' ? htmlspecialchars($_SESSION['name']) : 'Tài Khoản'; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                    <?php if (isset($_SESSION['name']) && $_SESSION['name'] !== ''): ?>
                                        <li><a class="dropdown-item" href="public/pages/logout.php">Đăng Xuất</a></li>
                                        <li><a class="dropdown-item" href="public/pages/account.php">Quản lí tài khoản</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="public/pages/login.php">Đăng nhập</a></li>
                                        <li><a class="dropdown-item" href="public/pages/register.php">Đăng Ký</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Search Box -->
            <div class="search-box">
                <form action="public/pages/search.php" method="get" class="d-flex">
                    <input type="text" id="search-input" name="query" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button type="submit" class="btn btn-orange">🔍</button>
                </form>
            </div>
        </div>
    </div>
</header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
