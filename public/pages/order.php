<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../includes/Order_Database.php";
require_once "../includes/Product_Database.php";
require_once "../includes/Database.php"; // Assuming this is needed for user data
$order_database = new Order_Database();
$orders = $order_database->getAllOrders();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            margin: 0;
        }
        .main-content {
            padding: 2rem;
            flex-grow: 1;
        }
        .main-content h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1.5rem;
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
        .btn-info {
            border-radius: 0.5rem;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            .main-content h2 {
                font-size: 1.5rem;
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
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <button class="btn btn-primary d-md-none mb-3" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h2 class="mb-3">Danh sách đơn hàng</h2>
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên đơn hàng</th>
                            <th>Tên người dùng</th>
                            <th>Tổng giá</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars("Đơn hàng #" . $order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars("User_" . $order['user_id']); ?></td>
                            <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td>
                                <button class="btn btn-info btn-sm view-details"
                                    data-order-id="<?php echo htmlspecialchars($order['order_id']); ?>" 
                                    data-bs-toggle="modal" data-bs-target="#orderDetailModal">Xem chi tiết</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Chi tiết đơn hàng -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Chi tiết</th>
                                    <th>ID Đơn hàng</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody id="orderDetailTableBody">
                                <!-- Order details will be populated via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                fetchOrderDetails(orderId);
            });
        });

        function fetchOrderDetails(orderId) {
            fetch(`../includes/get_order_details.php?order_id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('orderDetailTableBody');
                    tableBody.innerHTML = '';

                    if (data.error) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-danger">${data.error}</td></tr>`;
                        return;
                    }

                    data.forEach(detail => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${detail.order_detail_id}</td>
                            <td>${detail.order_id}</td>
                            <td>${detail.product_name}</td>
                            <td>${detail.quantity}</td>
                            <td>${Number(detail.price).toLocaleString('vi-VN')} VND</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Error fetching order details:", error);
                    document.getElementById('orderDetailTableBody').innerHTML = `
                        <tr><td colspan="5" class="text-danger">Lỗi khi tải dữ liệu</td></tr>
                    `;
                });
        }
    </script>
</body>
</html>