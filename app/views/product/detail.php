<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Nunito, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .product-image {
            width: 35%;
        }

        .product-image img {
            width: 100%;
            border-radius: 8px;
        }

        .product-info {
            width: 55%;
        }

        .product-info h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .product-info .price {
            font-size: 20px;
            color: #e74c3c;
            margin: 10px 0;
        }

        .quantity {
            margin-top: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity label {
            font-size: 16px;
            color: #333;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            font-size: 18px;
            text-align: center;
            cursor: pointer;
            outline: none;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
        }

        .quantity-btn:hover {
            background-color: #e0e0e0;
        }

        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid #ccc;
            font-size: 16px;
            border-radius: 5px;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            margin-top: 40px;
            gap: 10px;
        }

        .nut {
            flex: 1;
            padding: 10px;
            background-color: #12b560;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 17px;
        }

        .nut:hover {
            background-color: #0e9b4d;
        }

        .thongtin {
            width: 100%;
            margin-top: 20px;

            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            color: #333;
        }

        .product-image {
            text-align: center;
        }

        .main-image img {
            width: 400px; /* Size */
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .thumbnail-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
            border: 2px solid transparent;
            transition: transform 0.3s ease, border 0.3s ease;
        }

        .thumbnail:hover {
            transform: scale(1.1);
            border: 2px solid green;
        }

        /* Webkit (Chrome, Edge, Safari) */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        .flash-message {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none; /* Initially hidden */
            z-index: 1000;
            font-size: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .flash-message.show {
            display: block;
            animation: slide-in 0.5s ease-out forwards;
        }

    </style>
</head>
<div class="noi-dung">
    <body>
    <div class="container">
        <?php while ($row = mysqli_fetch_array($product)) { ?>
        <!-- Product Header -->
        <div class="product-header">
            <div class="product-image">

                <div class="main-image">
                    <img id="largeImage" src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image']; ?>" alt="">
                </div>


                <div class="thumbnail-container">
                    <img class="thumbnail" src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image1']; ?>"
                         alt="Ảnh 1" onclick="changeImage(this)">
                    <img class="thumbnail" src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image2']; ?>"
                         alt="Ảnh 2" onclick="changeImage(this)">
                    <img class="thumbnail" src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image3']; ?>"
                         alt="Ảnh 3" onclick="changeImage(this)">
                    <img class="thumbnail" src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image4']; ?>"
                         alt="Ảnh 4" onclick="changeImage(this)">
                </div>


            </div>
            <div class="product-info">
                <h1><?php echo htmlspecialchars($row['name']); ?></h1>
                <div class="price">
                    <p style="margin-top: -5px; color: green; font-weight: bold; text-decoration: none;">
                        VND <?php echo number_format($row['price'], 0, ',', '.'); ?>
                    </p>
                </div>
                <div class="quantity">
                    <label for="">Quantity:</label>
                    <button type="button" class="quantity-btn minus">-</button>
                    <input type="number" class="quantity-input" id="myInput" name="quantity" value="1" min="1"/>
                    <button type="button" class="quantity-btn plus">+</button>
                </div>
                <div class="action-buttons">
                    <form method="POST" action="/inis/cart/addItem/<?php echo $row['product_code']; ?>">
                        <input type="hidden" id="quantityAdd" name="quantity" value="1">
                        <button type="submit" class="nut">ADD TO CART</button>
                        <?php
                        if (isset($_SESSION['flash_message'])) {
                            echo "<div id='flash-message' class='flash-message'>" . $_SESSION['flash_message'] . "</div>";
                            unset($_SESSION['flash_message']);
                        }
                        ?>
                    </form>
                    <form method="POST" action="/inis/cart/processBuyNow/<?php echo $row['product_code']; ?>">
                        <input type="hidden" id="quantityBuy" name="quantity" value="1">
                        <button type="submit" class="nut">BUY NOW</button>
                    </form>
                </div>
                <div class="thongtin">
                    <?php echo $row['description']; ?>
                </div>
                <?php } ?>
            </div>

        </div>

    </div>
    </body>
</div>
<script>
    function changeImage(thumbnail) {
        let largeImage = document.getElementById("largeImage");
        largeImage.src = thumbnail.src;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const quantityInput = document.querySelector(".quantity-input");
        const minusBtn = document.querySelector(".quantity-btn.minus");
        const plusBtn = document.querySelector(".quantity-btn.plus");
        const quantityAdd = document.getElementById("quantityAdd");
        const quantityBuy = document.getElementById("quantityBuy");

        // Decrease quantity
        minusBtn.addEventListener("click", function () {
            let value = parseInt(quantityInput.value) || 1;
            if (value > 1) {
                value--;
                quantityInput.value = value;
                quantityAdd.value = value;
                quantityBuy.value = value;
            }
        });

        // Increase quantity
        plusBtn.addEventListener("click", function () {
            let value = parseInt(quantityInput.value) || 1;
            value++;
            quantityInput.value = value;
            quantityAdd.value = value;
            quantityBuy.value = value;
        });

        // Direct quantity input
        quantityInput.addEventListener("input", function () {
            const value = parseInt(quantityInput.value) || 1;
            quantityAdd.value = value;
            quantityBuy.value = value;
        });

        // Show flash message if any
        const flashMessage = document.getElementById("flash-message");
        if (flashMessage) {
            flashMessage.classList.add("show"); // Show message
            setTimeout(function () {
                flashMessage.style.display = "none"; // Hide after 5s
            }, 5000);
        }
    });
</script>


</html>
