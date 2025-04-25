<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quản lý đơn hàng</title>
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

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: white;
    }

    .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .table-responsive {
        max-height: 70vh;
        overflow-y: auto;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark">
                <div class="position-sticky pt-3">
                    <h4 class="text-white text-center mb-4">Admin Dashboard</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="dashboard.php"><i
                                    class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin.php"><i class="fas fa-users me-2"></i>Quản
                                lý người dùng</a></li>
                        <li class="nav-item"><a class="nav-link" href="quanlysanpham.php"><i
                                    class="fas fa-box me-2"></i>Sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link active" href="order.php"><i
                                    class="fas fa-shopping-cart me-2"></i>Đơn hàng</a></li>
                        <li class="nav-item"><a class="nav-link" href="report.php"><i
                                    class="fas fa-chart-bar me-2"></i>Báo cáo</a></li>
                        <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
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
                            <?php
                            require_once "../includes/Order_Database.php";
                            require_once "../includes/Product_Database.php";
                            require_once "../includes/Database.php"; // Assuming this is needed for user data
                            $order_database = new Order_Database();
                            $product_database = new Product_Database();
                            $orders = $order_database->getAllOrders();
                            foreach ($orders as $order) {
                                // Placeholder for user name (assuming a users table exists)
                                $user_name = "User_" . $order['user_id']; // Replace with actual user name retrieval logic
                                $order_name = "Đơn hàng #" . $order['order_id']; // Placeholder for order name
                            ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order_name; ?></td>
                                <td><?php echo $user_name; ?></td>
                                <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</td>
                                <td><?php echo $order['status']; ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm view-details"
                                        data-order-id="<?php echo $order['order_id']; ?>" data-bs-toggle="modal"
                                        data-bs-target="#orderDetailModal">Xem chi tiết</button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Chi tiết đơn hàng -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel"
        aria-hidden="true">
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

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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