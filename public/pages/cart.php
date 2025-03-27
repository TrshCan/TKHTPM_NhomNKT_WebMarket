<?php
session_start();
include '../includes/header.php';

// Calculate total if cart exists
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>

<!-- Main Content -->
<main class="cart-page container my-5">
    <h1 class="text-center mb-4">Giỏ Hàng</h1>
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info text-center" role="alert">
            Giỏ hàng của bạn đang trống. <a href="index.php" class="alert-link">Tiếp tục mua sắm!</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-warning text-dark">
                    <tr>
                        <th scope="col">Hình Ảnh</th>
                        <th scope="col">Sản Phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số Lượng</th>
                        <th scope="col">Tổng</th>
                        <th scope="col">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <tr>
                            <td>
                                <img src="../assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" class="img-thumbnail" style="width: 80px; height: 80px;">
                            </td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 0) . 'đ'; ?></td>
                            <td>
                                <input type="number" class="form-control w-25 mx-auto" value="<?php echo $item['quantity']; ?>" min="1" readonly>
                            </td>
                            <td><?php echo number_format($item['price'] * $item['quantity'], 0) . 'đ'; ?></td>
                            <td>
                                <a href="#" onclick="confirmDelete('<?php echo $id; ?>')" class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                        <td class="fw-bold"><?php echo number_format($total, 0) . 'đ'; ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-3">
            <a href="#" onclick="confirmDeleteAll()" class="btn btn-warning">Xóa Tất Cả</a>
            <a href="checkout.php" class="btn btn-primary checkout-btn">Thanh Toán</a>
        </div>
    <?php endif; ?>
</main>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-4">
    <p>© 2025 Website Bán Hàng. All rights reserved.</p>
</footer>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?")) {
            window.location.href = "../includes/cart_crud.php?action=delete&id=" + id;
        }
    }

    function confirmDeleteAll() {
        if (confirm("Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?")) {
            window.location.href = "../includes/cart_crud.php?action=deleteall";
        }
    }
</script>
</body>
</html>
