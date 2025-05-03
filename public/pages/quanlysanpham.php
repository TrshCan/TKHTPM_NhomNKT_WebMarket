<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../includes/Product_Database.php";
$product_database = new Product_Database();
$products = $product_database->getAllProducts();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
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
        .btn-success {
            border-radius: 0.5rem;
        }
        .btn-warning, .btn-danger {
            border-radius: 0.5rem;
        }
        #addProductFormContainer {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
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
            <h2 class="mb-3">Danh sách sản phẩm</h2>
            
            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Danh mục</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['category_id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" width="50" alt="Product Image"></td>
                            <td><?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><?php echo htmlspecialchars($product['status']); ?></td>
                            <td>
                                <a href="edit_product.php?action=edit&id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="../includes/process_product.php?action=delete&product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Product Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn btn-success" id="toggleFormBtn">Thêm sản phẩm</button>
            </div>

            <!-- Add Product Form -->
            <div id="addProductFormContainer" style="display: none;">
                <form id="addProductForm" action="../includes/process_product.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh</label>
                        <input type="text" class="form-control" name="image">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tồn kho</label>
                        <input type="number" class="form-control" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-control" name="status">
                            <option value="có sẵn">Có sẵn</option>
                            <option value="hết hàng">Hết hàng</option>
                        </select>
                    </div>
                    <div id="responseMessage" class="text-danger"></div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="cancelFormBtn">Hủy</button>
                        <button type="submit" class="btn btn-success" value="add" name="action">Thêm</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        document.getElementById("toggleFormBtn").addEventListener("click", function() {
            var formContainer = document.getElementById("addProductFormContainer");
            formContainer.style.display = (formContainer.style.display === "none" || formContainer.style.display === "") ? "block" : "none";
        });

        document.getElementById("cancelFormBtn").addEventListener("click", function() {
            document.getElementById("addProductFormContainer").style.display = "none";
        });
    </script>
</body>
</html>