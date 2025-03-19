<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="<?php echo WEBROOT; ?>public/huhu.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .duong_dan ul li .dropdown-menu {
            display: none;
        }

        body {
            background: linear-gradient(to bottom right, rgb(134, 204, 118), rgb(217, 235, 215));
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }


        .cart-container {
            align-items: center;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            color: green;
        }

        .cart-items {
            align-items: center;
            display: flex;
            flex-direction: column; /* Sắp xếp các sản phẩm theo cột (mỗi sản phẩm 1 dòng) */
            gap: 20px;
        }

        .cart-item {
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row; /* Sắp xếp các thành phần của sản phẩm theo dòng ngang */
            justify-content: space-between; /* Căn chỉnh các thành phần */
            width: 50%;
            align-items: center;
        }

        h2 {
            color: white;
            text-align: center;
        }

        .cart-item-info {
            text-align: left;
            margin-right: 10px;
        }

        .cart-item-info p {
            margin: 10px 0;
        }

        .cart-item-image img {
            width: 70%;
            height: auto;
            max-width: 150px;
            margin-right: 10px;
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .quantity-input {
            border: none;
            width: 60px;
            margin-bottom: 10px;

        }

        .delete-btn {
            background: none;
            border: none;

            color: red;
            cursor: pointer;
            font-size: 20px;
        }

        .delete-btn:hover {
            color: darkred;
        }

        .delete-btn i {
            font-size: 18px;
        }

        .btn-quaylai {
            display: inline-block;
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
        }


        .cart-total {
            position: fixed;
            right: 20px;
            bottom: 80px;
            font-size: 20px;
            font-weight: bolder;
            color: rgb(9, 65, 22);
            text-align: right;
            width: 250px;
            border-radius: 8px;
        }

        .checkout-section {
            position: fixed;
            right: 20px;
            bottom: 20px;
        }

        .btn-checkout {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(245, 248, 245);
            color: #218838;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #218838;
            font-size: 16px;
            margin-top: 20px;
            font-size: 20px;
        }

        .btn-thanh-toan:hover {
            background-color: #218838;
            color: white;
        }

        #confirmModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 300px;
        }

        button {
            margin: 5px;
            padding: 10px;
            font-size: 16px;
        }

        .cart-item-info {
            width: 50%;

        }

        .quantity-input {
            width: 30px;
            text-align: center;
            font-size: 16px;
            background-color: transparent;

        }

        /* Style cho container chứa nút + - */
        .quantity-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Style cho nút + và - */
        .btn-decrease, .btn-increase {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Hover hiệu ứng */
        .btn-decrease:hover, .btn-increase:hover {
            background-color: #218838;
        }

        #confirmYes {
            border-radius: 5px;
            background-color: #218838;
            border: white;
            color: white;
            cursor: pointer;
        }

        #confirmNo {
            border-radius: 5px;
            background-color: rgb(230, 12, 34);
            border: white;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>


<div class="cart-container">
    <h2>CART</h2>
    <div class="back-link">
        <a href="<?php echo WEBROOT; ?>product/index" class="btn-back">⬅ Products</a>
    </div>
    <?php if (!empty($cart)): ?>

        <div class="cart-items">

            <?php foreach ($cart as $item): ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="<?php echo WEBROOT; ?>public/img/<?php echo $item['image'] ?>" alt="product">
                    </div>
                    <div class="cart-item-info">
                        <p><strong></strong> <?= htmlspecialchars($item['name']) ?></p>
                        <p style="font-weight: bolder;">
                            <strong></strong> <?php echo number_format($item['price'], 0, ',', '.'); ?>đ</p>
                    </div>

                    <div class="cart-item-actions">
                        <div class="quantity-container">
                            <button type="button" class="btn-decrease"
                                    data-product-code="<?= htmlspecialchars($item['product_code']) ?>">−
                            </button>
                            <input type="number" class="quantity-input"
                                   data-product-code="<?= htmlspecialchars($item['product_code']) ?>"
                                   value="<?= htmlspecialchars($item['quantity']) ?>"
                                   min="1" step="1" readonly>
                            <button type="button" class="btn-increase"
                                    data-product-code="<?= htmlspecialchars($item['product_code']) ?>">+
                            </button>
                        </div>
                        <form method="POST" action="<?= WEBROOT ?>cart/removeItem"
                              id="removeForm_<?= $item['product_code'] ?>">
                            <input type="hidden" name="product_code" value="<?= htmlspecialchars($item['product_code']) ?>">
                            <button type="button" class="delete-btn" data-product-code="<?= $item['product_code'] ?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="confirmModal" style="display:none;">
            <div class="modal-content">
                <p style="color: black;">Are you sure you want to remove this item?</p>
                <button id="confirmYes">Yes</button>
                <button id="confirmNo">No</button>
            </div>
        </div>

    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>


    <!-- Total -->
    <div class="cart-total" id="cartTotal">
        <p>Total: VND</p>
    </div>


    <?php
    $cartEmpty = empty($_SESSION['cart']); // Kiểm tra giỏ hàng có trống không
    ?>

    <div class="checkout-section">
        <a href="<?php echo !$cartEmpty ? WEBROOT . 'cart/checkout' : 'javascript:void(0)'; ?>"
           class="btn-checkout <?php echo $cartEmpty ? 'disabled' : ''; ?>"
            <?php echo $cartEmpty ? 'style="background-color: gray; border: 1px solid gray; cursor: not-allowed; pointer-events: none; color: white;"' : ''; ?>>
            Checkout
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Confirm remove item
            $('.delete-btn').click(function (e) {
                e.preventDefault(); // Ngăn hành động mặc định của form
                var productCode = $(this).data('product-code');
                confirmDelete(productCode);
            });

            var productCodeToDelete = null;

            function confirmDelete(productCode) {
                productCodeToDelete = productCode;
                // Show confirm modal
                $('#confirmModal').show();
            }

            // On confirm, remove item
            $('#confirmYes').click(function () {
                if (productCodeToDelete) {
                    var form = $('#removeForm_' + productCodeToDelete);
                    form.submit();
                }
                closeModal();  // Đóng modal sau khi xóa
            });

            // Close modal on cancel
            $('#confirmNo').click(function () {
                closeModal();
            });

            function closeModal() {
                $('#confirmModal').hide();
                productCodeToDelete = null;
            }

            $('.btn-increase').click(function () {
                var input = $(this).siblings('.quantity-input');
                var productCode = $(this).data('product-code');
                var currentValue = parseInt(input.val());
                var newValue = currentValue + 1;
                checkAndUpdateQuantity(productCode, newValue, input);
            });

            // Decrease quantity button
            $('.btn-decrease').click(function () {
                var input = $(this).siblings('.quantity-input');
                var productCode = $(this).data('product-code');
                var currentValue = parseInt(input.val());
                if (currentValue > 1) {
                    var newValue = currentValue - 1;
                    checkAndUpdateQuantity(productCode, newValue, input);
                }
            });

            function checkAndUpdateQuantity(productCode, newQuantity, inputElement) {
                $.ajax({
                    url: '<?php echo WEBROOT; ?>cart/checkQuantity',
                    type: 'POST',
                    data: {
                        product_code: productCode,
                        quantity: newQuantity
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            // Update cart if valid quantity
                            updateQuantity(productCode, newQuantity, inputElement);
                        } else {
                            // Show message if exceeds stock
                            alert('Quantity exceeds stock! Available: ' + data.available + ' items');
                        }
                    },
                    error: function () {
                        alert('Error checking quantity!');
                    }
                });
            }

            // Hàm gửi yêu cầu AJAX để cập nhật số lượng
            function updateQuantity(productCode, newQuantity, inputElement) {
                $.ajax({
                    url: '<?php echo WEBROOT; ?>cart/updateQuantity',
                    type: 'POST',
                    data: {
                        product_code: productCode,
                        quantity: newQuantity
                    },
                    success: function (response) {
                        inputElement.val(newQuantity);
                        updateCartTotal(); // Cập nhật tổng tiền
                        updateCartCount(); // Cập nhật số lượng trên icon
                    },
                    error: function () {
                        alert('Error updating quantity!');
                    }
                });
            }

            // Hàm cập nhật tổng tiền giỏ hàng
            function updateCartTotal() {
                var total = 0;
                $('.cart-item').each(function () {
                    var quantity = parseInt($(this).find('.quantity-input').val());
                    var unitPriceText = $(this).find('.cart-item-info p:nth-child(2)').text();
                    var unitPrice = parseFloat(unitPriceText.replace('đ', '').replace(/\./g, '').replace(',', '.'));
                    total += (quantity * unitPrice);
                });

                var formattedTotal = total.toLocaleString('vi-VN') + 'đ';
                $('#cartTotal p').text('Total: ' + formattedTotal);
            }

            // Hàm cập nhật số lượng trên icon giỏ hàng
            function updateCartCount() {
                $.ajax({
                    url: '<?php echo WEBROOT; ?>cart/getCartCount',
                    type: 'GET',
                    success: function (response) {
                        console.log(response)
                        var count = parseInt(response);
                        if (count > 0) {
                            $('.cart-count').text(count).show();
                        } else {
                            $('.cart-count').hide();
                        }
                    },
                    error: function () {
                        console.log('Lỗi khi lấy số lượng giỏ hàng');
                    }
                });
            }

            // Cập nhật tổng tiền và số lượng khi trang tải
            updateCartTotal();
            updateCartCount();
        });
    </script>
</body>
</html>
