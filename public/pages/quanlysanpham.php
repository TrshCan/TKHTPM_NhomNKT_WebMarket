<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">

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
                <?php
                require_once "../includes/Product_Database.php";
                $product_database = new Product_Database();
                $products = $product_database->getAllProducts();
                foreach ($products as $product) {
                ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><?php echo $product['category_id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><img src="../assets/images/<?= $product['image']; ?>" width="50"></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><?php echo $product['status']; ?></td>
                    <td>
                        <a href="edit_product.php?action=edit&id=<?php echo $product['product_id'] ?>"
                            class="btn btn-warning btn-sm">Sửa</a>
                        <a href="../includes/process_product.php?action=delete&product_id=<?= $product['product_id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick='return confirm("Bạn có chắc chắn muốn xóa không?");'>Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Thêm Sản Phẩm -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">

            <button class="btn btn-success" id="toggleFormBtn">Thêm sản phẩm</button>
        </div>

        <div id="addProductFormContainer" style="display: none;">
            <form id="addProductForm" action="../includes/process_product.php">

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
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById("toggleFormBtn").addEventListener("click", function() {
        var formContainer = document.getElementById("addProductFormContainer");
        formContainer.style.display = (formContainer.style.display === "none" || formContainer.style.display ===
            "") ? "block" : "none";
    });

    document.getElementById("cancelFormBtn").addEventListener("click", function() {
        document.getElementById("addProductFormContainer").style.display = "none";
    });
    </script>

</body>

</html>