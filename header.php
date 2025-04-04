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

</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo">N<span>K</span>T</div>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php" style="font-family: 'Arial', sans-serif;">Trang Chủ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="public\pages\cart.php" style="font-family: 'Arial', sans-serif;">Giỏ Hàng</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" style="font-family: 'Arial', sans-serif;">
                                <?php echo isset($_SESSION['name']) && $_SESSION['name'] !== '' ? htmlspecialchars($_SESSION['name']) : 'Tài Khoản'; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <?php if (isset($_SESSION['name']) && $_SESSION['name'] !== ''): ?>
                                    <li><a class="dropdown-item" href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/TKHTPM_NhomNKT_WebMarket.git/public/pages/logout.php">Đăng Xuất</a></li>
                                    <li><a class="dropdown-item" href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/TKHTPM_NhomNKT_WebMarket.git/public/pages/account.php">Quản lí tài khoản</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/TKHTPM_NhomNKT_WebMarket.git/public/pages/login.php">Đăng nhập</a></li>
                                    <li><a class="dropdown-item" href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/TKHTPM_NhomNKT_WebMarket.git/public/pages/register.php">Đăng Ký</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="search-box">
            <form action="/TKHTPM_NhomNKT_WebMarket.git/public/pages/search.php" method="get">
                <input type="text" id="search-input" name="query" placeholder="Tìm kiếm sản phẩm...">
                <button type="submit">🔍</button>
            </form>
        </div>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>