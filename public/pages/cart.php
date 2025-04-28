<?php
session_start();
include '../includes/header.php';
include '../includes/Product_Database.php';

$products = new Product_Database();
// Calculate total if cart exists
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id=>$items) {
        $item = $products->getProductById2($id);
        $total += $item['price'] * $items['quantity'];
    }
}
?>

<!-- Main Content -->
<main class="cart-page container my-5">
    <h1 class="text-center mb-4">Giỏ Hàng</h1>
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info text-center" role="alert">
            Giỏ hàng của bạn đang trống. <a href="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']; ?>/TKHTPM_NhomNKT_WebMarket.git/index.php" class="alert-link">Tiếp tục mua sắm!</a>
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
                    <?php foreach ($_SESSION['cart'] as $id=>$items): 
                        $item = $products->getProductById2($id)?>
                        <tr>
                            <td>
                                <img src="../assets/images/<?php echo $item['image']; ?>" alt="Product Image" class="img-thumbnail" style="width: 80px; height: 80px;">
                            </td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['price'] . 'đ'; ?></td>
                            <td>
                                <input type="number" class="form-control w-25 mx-auto" value="<?php echo $items['quantity']; ?>" min="1" readonly>
                            </td>
                            <td><?php echo $item['price'] * $items['quantity'] . 'đ'; ?></td>
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
            <a href="#" onclick="confirmDeleteAll()" class="btn btn-warning my-4">Xóa Tất Cả</a>
            <a href="checkout.php" class="btn btn-primary checkout-btn my-4">Thanh Toán</a>
        </div>
    <?php endif; ?>
</main>

<!-- Footer -->
<?php include '../../footer.php';?>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
