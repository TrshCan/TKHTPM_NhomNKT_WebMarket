<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar d-md-block" id="sidebar">
    <div class="position-sticky pt-3">
        <h4 class="text-white text-center mb-4">Admin Dashboard</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $current_page == 'admin.php' ? 'active' : ''; ?>" href="admin.php"><i class="fas fa-users"></i> Quản Lý Người Dùng</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $current_page == 'quanlysanpham.php' ? 'active' : ''; ?>" href="quanlysanpham.php"><i class="fas fa-box"></i> Sản Phẩm</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $current_page == 'order.php' ? 'active' : ''; ?>" href="order.php"><i class="fas fa-shopping-cart"></i> Đơn Hàng</a></li>
            <li class="nav-item"><a class="nav-link <?php echo $current_page == 'logout.php' ? 'active' : ''; ?>" href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
        </ul>
    </div>
</div>

<style>
    .sidebar {
        min-height: 100vh;
        background-color: #1f2937;
        padding-top: 1rem;
    }
    .sidebar .nav-link {
        color: #d1d5db;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        margin: 0.25rem 1rem;
        transition: all 0.3s ease;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
        color: #ffffff;
        background-color: #3b82f6;
    }
    .sidebar .nav-link i {
        margin-right: 0.5rem;
    }
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            z-index: 1000;
            width: 250px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .sidebar.show {
            transform: translateX(0);
        }
    }
</style>