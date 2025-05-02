<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = 'Chi Tiết Sản Phẩm';
include "../../header.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Chi tiết sản phẩm - NKT Shop">
    <meta name="author" content="NKT Team">
    <title><?php echo htmlspecialchars($page_title); ?> - NKT</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
        }
        .product-section {
            padding: 4rem 0;
        }
        .product-section img {
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            width: 100%;
            max-height: 500px;
        }
        .product-section h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        .product-section .price {
            font-size: 1.5rem;
            color: #3b82f6;
            font-weight: 600;
        }
        .product-section .description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .btn-add-to-cart, .btn-buy-now {
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-add-to-cart {
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
        }
        .btn-add-to-cart:hover {
            background-color: #1e40af;
        }
        .btn-buy-now {
            background-color: #f59e0b;
            color: #ffffff;
            border: none;
            margin-left: 1rem;
        }
        .btn-buy-now:hover {
            background-color: #d97706;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            max-width: 4rem;
            text-align: center;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        .related-products {
            padding: 2rem 0;
        }
        .related-products h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .product-card {
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            border-radius: 0.5rem;
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .product-card h3 {
            font-size: 1.25rem;
            color: #1f2937;
            margin: 0.75rem 0;
        }
        .product-card .price {
            font-size: 1.1rem;
            color: #3b82f6;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .product-card .btn-add-to-cart {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        .alert-success {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            border-radius: 0.5rem;
        }
        @media (max-width: 768px) {
            .product-section {
                padding: 2rem 0;
            }
            .product-section h1 {
                font-size: 1.75rem;
            }
            .product-section img {
                max-height: 300px;
            }
            .btn-add-to-cart, .btn-buy-now {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            .related-products h2 {
                font-size: 1.5rem;
            }
            .product-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php
    require_once "../includes/Product_Database.php";
    $productsdb = new Product_Database();
    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
        $product_id = (int)$_GET['product_id'];
        $products = $productsdb->getProductById($product_id);
        if (empty($products)) {
            echo '<div class="container text-center py-5"><h3>Sản phẩm không tồn tại.</h3></div>';
        } else {
            foreach ($products as $value) {
    ?>
    <section class="product-section">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img src="../assets/images/<?php echo htmlspecialchars($value['image']); ?>" 
                         alt="<?php echo htmlspecialchars($value['name']); ?>" 
                         class="img-fluid" />
                </div>
                <div class="col-md-6">
                    <div class="small mb-1 text-muted">Mã: <?php echo htmlspecialchars($value['product_id']); ?></div>
                    <h1><?php echo htmlspecialchars($value['name']); ?></h1>
                    <div class="price mb-3"><?php echo number_format($value['price'], 0, ',', '.'); ?>đ</div>
                    <p class="description"><?php echo htmlspecialchars($value['description']); ?></p>
                    <div class="d-flex align-items-center">
                        <input class="form-control me-3" id="inputQuantity" type="number" value="1" min="1" max="100" />
                        <button class="btn-add-to-cart" 
                                onclick="addToCart(<?php echo $value['product_id']; ?>, document.getElementById('inputQuantity').value)">
                            Thêm vào giỏ
                        </button>
                        <button class="btn-buy-now" onclick="buyNow(<?php echo $value['product_id']; ?>)">
                            Mua Ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
            }
        }
    } else {
        echo '<div class="container text-center py-5"><h3>Vui lòng chọn một sản phẩm.</h3></div>';
    }
    ?>

    <?php if (!empty($products)): ?>
    <section class="related-products">
        <div class="container px-4 px-lg-5">
            <h2>Sản Phẩm Liên Quan</h2>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php
                $related_products = $productsdb->getRelatedProducts($product_id);
                if (empty($related_products)) {
                    echo '<p class="text-center text-muted">Không có sản phẩm liên quan.</p>';
                } else {
                    foreach ($related_products as $related) {
                ?>
                <div class="col">
                    <div class="product-card">
                        <img src="../assets/images/<?php echo htmlspecialchars($related['image']); ?>" 
                             alt="<?php echo htmlspecialchars($related['name']); ?>" 
                             loading="lazy" />
                        <h3><?php echo htmlspecialchars($related['name']); ?></h3>
                        <p class="price"><?php echo number_format($related['price'], 0, ',', '.'); ?>đ</p>
                        <button class="btn-add-to-cart" 
                                onclick="addToCart(<?php echo $related['product_id']; ?>, 1)">
                            Thêm Vào Giỏ
                        </button>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php include "../../footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(productId, quantity) {
            if (quantity < 1 || quantity > 100) {
                alert('Số lượng phải từ 1 đến 100.');
                return;
            }
            window.location.href = `../includes/cart_crud.php?action=add&id=${productId}&quantity=${quantity}`;
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.role = 'alert';
            alert.innerHTML = `
                Đã thêm sản phẩm vào giỏ hàng!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3000);
        }

        function buyNow(productId) {
            const quantity = document.getElementById('inputQuantity').value;
            if (quantity < 1 || quantity > 100) {
                alert('Số lượng phải từ 1 đến 100.');
                return;
            }
            // Redirect to checkout page (implement as needed)
            window.location.href = `../includes/cart_crud.php?action=add&id=${productId}&quantity=${quantity}&buy_now=1`;
        }
    </script>
</body>
</html>