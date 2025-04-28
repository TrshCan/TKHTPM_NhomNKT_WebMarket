<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('BASE_URL', 'http://localhost/TKHTPM_NhomNKT_WebMarket/');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title ?? 'Website Bán Hàng'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffffff !important;
            transition: color 0.3s ease;
        }
        .navbar-brand:hover {
            color: #e0f2fe !important;
        }
        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #e0f2fe !important;
        }
        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .dropdown-item {
            color: #1f2937;
            transition: background-color 0.3s ease;
        }
        .dropdown-item:hover {
            background-color: #e0f2fe;
            color: #1e3a8a;
        }
        .search-box .form-control {
            border-radius: 0.5rem 0 0 0.5rem;
            border: none;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        .search-box .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        .search-box .btn {
            border-radius: 0 0.5rem 0.5rem 0;
            background-color: #ffffff;
            color: #3b82f6;
            border: none;
            transition: background-color 0.3s ease;
        }
        .search-box .btn:hover {
            background-color: #e0f2fe;
            color: #1e3a8a;
        }
        .logo {
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
        }
        .logo span {
            color: #f59e0b;
        }
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }
            .search-box {
                margin-top: 1rem;
                width: 100%;
            }
            .search-box form {
                width: 100%;
            }
            .logo {
                text-align: center;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand logo" href="<?php echo BASE_URL; ?>index.php">
                    N<span>K</span>T
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Trang Chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>public/pages/cart.php">Giỏ Hàng</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo isset($_SESSION['name']) && $_SESSION['name'] !== '' ? htmlspecialchars($_SESSION['name']) : 'Tài Khoản'; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <?php if (isset($_SESSION['name']) && $_SESSION['name'] !== ''): ?>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>public/pages/logout.php">Đăng Xuất</a></li>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>public/pages/account.php">Quản lý tài khoản</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>public/pages/login.php">Đăng nhập</a></li>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>public/pages/register.php">Đăng Ký</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="nav-item search-box ms-3">
                            <form action="<?php echo BASE_URL; ?>public/pages/search.php" method="get" class="d-flex">
                                <input type="text" id="search-input" name="query" class="form-control" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                                <button type="submit" class="btn">🔍</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>