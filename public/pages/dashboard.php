<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../includes/Database.php";
require_once "../includes/Admin_Database.php";
$adminDB = new Admin_Database();

// Fetch summary data
$total_users = $adminDB->getTotalUsers();
$total_orders = $adminDB->getTotalOrders();
$total_products = $adminDB->getTotalProducts();
$total_revenue = $adminDB->getTotalRevenue();

// Fetch recent orders
$recent_orders = $adminDB->getRecentOrders(5);

// Fetch monthly revenue for chart
$monthly_revenue = $adminDB->getMonthlyRevenue();

// Fetch product category distribution
$category_distribution = $adminDB->getCategoryDistribution();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
        }
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
        .main-content {
            padding: 2rem;
        }
        .main-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1.5rem;
        }
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .card.bg-primary {
            background-color: #3b82f6 !important;
        }
        .card.bg-success {
            background-color: #059669 !important;
        }
        .card.bg-info {
            background-color: #0ea5e9 !important;
        }
        .card.bg-warning {
            background-color: #f59e0b !important;
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
        .btn-primary {
            background-color: #3b82f6;
            border: none;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #1e40af;
        }
        .btn-outline-secondary {
            border-radius: 0.5rem;
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
            .main-content {
                padding: 1rem;
            }
            .main-content h1 {
                font-size: 1.5rem;
            }
            .card {
                margin-bottom: 1rem;
            }
            .table th, .table td {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-md-block" id="sidebar">
            <div class="position-sticky pt-3">
                <h4 class="text-white text-center mb-4">Admin Dashboard</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php"><i class="fas fa-users"></i> Quản Lý Người Dùng</a></li>
                    <li class="nav-item"><a class="nav-link" href="quanlysanpham.php"><i class="fas fa-box"></i> Sản Phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php"><i class="fas fa-shopping-cart"></i> Đơn Hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="report.php"><i class="fas fa-chart-bar"></i> Báo Cáo</a></li>
                    <li class="nav-item"><a class="nav-link" href="settings.php"><i class="fas fa-cog"></i> Cài Đặt</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            <button class="btn btn-primary d-md-none mb-3" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1>Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <i class="fas fa-calendar"></i> Tuần Này
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body text-center">
                            <i class="fas fa-users card-icon"></i>
                            <h5 class="card-title">Người Dùng</h5>
                            <h2 class="card-text"><?php echo number_format($total_users); ?></h2>
                            <a href="admin.php" class="text-white">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-cart card-icon"></i>
                            <h5 class="card-title">Đơn Hàng</h5>
                            <h2 class="card-text"><?php echo number_format($total_orders); ?></h2>
                            <a href="order.php" class="text-white">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body text-center">
                            <i class="fas fa-box card-icon"></i>
                            <h5 class="card-title">Sản Phẩm</h5>
                            <h2 class="card-text"><?php echo number_format($total_products); ?></h2>
                            <a href="quanlysanpham.php" class="text-white">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body text-center">
                            <i class="fas fa-dollar-sign card-icon"></i>
                            <h5 class="card-title">Doanh Thu</h5>
                            <h2 class="card-text"><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</h2>
                            <a href="report.php" class="text-white">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-1"></i> Doanh Thu Theo Tháng
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-pie me-1"></i> Phân Loại Sản Phẩm
                        </div>
                        <div class="card-body">
                            <canvas id="productChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Đơn Hàng Gần Đây
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_orders)): ?>
                                    <?php foreach ($recent_orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo htmlspecialchars($order['order_id']); ?></td>
                                            <td><?php echo htmlspecialchars($order['user_name'] ?: 'N/A'); ?></td>
                                            <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?>đ</td>
                                            <td>
                                                <span class="badge <?php
                                                    switch ($order['status']) {
                                                        case 'Hoàn thành': echo 'bg-success'; break;
                                                        case 'Đang xử lý': echo 'bg-warning'; break;
                                                        case 'Đã hủy': echo 'bg-danger'; break;
                                                        case 'Đang giao': echo 'bg-info'; break;
                                                        default: echo 'bg-secondary';
                                                    }
                                                ?>">
                                                    <?php echo htmlspecialchars($order['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="order.php?id=<?php echo htmlspecialchars($order['order_id']); ?>" class="btn btn-sm btn-primary">Xem</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center">Không có đơn hàng nào.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Revenue chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode(array_column($monthly_revenue, 'month')); ?>,
                    datasets: [{
                        label: 'Doanh Thu',
                        data: <?php echo json_encode(array_column($monthly_revenue, 'revenue')); ?>,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Product chart
            const productCtx = document.getElementById('productChart').getContext('2d');
            const productChart = new Chart(productCtx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode(array_column($category_distribution, 'category_name')); ?>,
                    datasets: [{
                        label: 'Sản Phẩm',
                        data: <?php echo json_encode(array_column($category_distribution, 'count')); ?>,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.6)',
                            'rgba(16, 185, 129, 0.6)',
                            'rgba(245, 158, 11, 0.6)',
                            'rgba(239, 68, 68, 0.6)'
                        ],
                        borderColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#ef4444'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        });
    </script>
</body>
</html>