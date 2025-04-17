<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .sidebar .nav-link:hover {
            color: white;
        }
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Dashboard</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">
                                <i class="fas fa-users me-2"></i>Quản lý người dùng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="quanlysanpham.php">
                                <i class="fas fa-box me-2"></i>Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-shopping-cart me-2"></i>Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar me-2"></i>Báo cáo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog me-2"></i>Cài đặt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <i class="fas fa-calendar"></i> This week
                        </button>
                    </div>
                </div>
                <!-- Summary cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-users card-icon"></i>
                                <h5 class="card-title">Người dùng</h5>
                                <h2 class="card-text">1,024</h2>
                                <a href="#" class="text-white">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-shopping-cart card-icon"></i>
                                <h5 class="card-title">Đơn hàng</h5>
                                <h2 class="card-text">256</h2>
                                <a href="#" class="text-white">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-box card-icon"></i>
                                <h5 class="card-title">Sản phẩm</h5>
                                <h2 class="card-text">78</h2>
                                <a href="#" class="text-white">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-dollar-sign card-icon"></i>
                                <h5 class="card-title">Doanh thu</h5>
                                <h2 class="card-text">$12,345</h2>
                                <a href="#" class="text-white">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Charts and tables -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-line me-1"></i>
                                Doanh thu theo tháng
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-1"></i>
                                Phân loại sản phẩm
                            </div>
                            <div class="card-body">
                                <canvas id="productChart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Đơn hàng gần đây
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên khách hàng</th>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#12345</td>
                                        <td>Nguyễn Văn A</td>
                                        <td>iPhone 13</td>
                                        <td>1</td>
                                        <td>$999</td>
                                        <td><span class="badge bg-success">Hoàn thành</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">Xem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#12344</td>
                                        <td>Trần Thị B</td>
                                        <td>MacBook Pro</td>
                                        <td>1</td>
                                        <td>$1,299</td>
                                        <td><span class="badge bg-warning">Đang xử lý</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">Xem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#12343</td>
                                        <td>Lê Văn C</td>
                                        <td>AirPods Pro</td>
                                        <td>2</td>
                                        <td>$498</td>
                                        <td><span class="badge bg-danger">Đã hủy</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">Xem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#12342</td>
                                        <td>Phạm Thị D</td>
                                        <td>iPad Air</td>
                                        <td>1</td>
                                        <td>$599</td>
                                        <td><span class="badge bg-info">Đang giao</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">Xem</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#12341</td>
                                        <td>Hoàng Văn E</td>
                                        <td>Apple Watch</td>
                                        <td>1</td>
                                        <td>$399</td>
                                        <td><span class="badge bg-success">Hoàn thành</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">Xem</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample charts
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                    datasets: [{
                        label: 'Doanh thu',
                        data: [5000, 8000, 6500, 9000, 12000, 15000],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Product chart
                        // Product chart
                        const productCtx = document.getElementById('productChart').getContext('2d');
            const productChart = new Chart(productCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Điện thoại', 'Laptop', 'Phụ kiện', 'Khác'],
                    datasets: [{
                        label: 'Sản phẩm',
                        data: [40, 25, 20, 15],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });

            });
        
    </script>
</body>
</html>
