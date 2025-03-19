<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        main {
            font-family: "Nunito", sans-serif;
        }

        .category-sidebar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #12b560;
            border-radius: 0 0 15px 15px;
            position: relative;
        }

        .loai-wrapper {
            position: relative;
            text-align: center;

        }

        .loai-wrapper > a {
            font-size: 19px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .chanhocx2 {
            display: none;
            position: absolute;
            top: 100%; /* Đảm bảo danh mục con nằm ngay dưới */
            left: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            padding: 10px 0;
            z-index: 100;
        }

        .chanhocx2 li {
            list-style: none;
            padding: 8px 15px;
        }

        .chanhocx2 li a {
            text-decoration: none;
            color: black;
            font-size: 14px;
            display: block;
            transition: background 0.3s;
        }

        .chanhocx2 li a:hover {
            color: #12b560;
            background-color: #f0f0f0;
        }

        .loai-wrapper:hover > a {
            color: rgb(24, 116, 50);
            background-color: rgba(255, 255, 255, 0.2); /* Hiệu ứng nền nhẹ */
            border-radius: 8px; /* Bo tròn góc */
            padding: 10px;
            transition: all 0.3s ease-in-out;
        }

        a {
            text-decoration: none;
            color: black;
        }

        img {
            width: 200px;
            height: 200px;
        }

        .full {
            width: 80%;
            margin: 0 auto;

        }

        .product {
            margin-left: 30px;
        }

        .product-detail {
            display: grid;
            grid-template-columns: repeat(4, 200px);
            gap: 80px;
        }

        .item {
            text-align: center;
        }

        .buy-now {
            background-color: white;
            color: green;
            border: 1px solid #12b560;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            width: 90%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .buy-now:hover {
            background-color: #1e8449;
            color: white;
        }


        .toggle-icon {
            cursor: pointer;
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .category-item.active .toggle-icon {
            transform: rotate(180deg);
        }

        span {
            font-size: 20px;
            color: green;
            font-weight: bold;
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
<body>
<main>
    <div class="full">
        <div class="category-sidebar">
            <?php while ($row = mysqli_fetch_array($productTypes)) { ?>
                <div class="loai-wrapper">
                    <a href="/inis/product/byType/<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </a>
                    <ul class="chanhocx2">
                        <?php
                        mysqli_data_seek($categories, 0);
                        while ($categoryRow = mysqli_fetch_array($categories)) {
                            if ($categoryRow['product_type_id'] == $row['id']) { ?>
                                <li>
                                    <a href="/inis/product/byCategory/<?php echo $categoryRow['id']; ?>">
                                        <?php echo $categoryRow['name']; ?>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <div class="product">
            <p style="margin-top:22px;margin-bottom:22px;">

                <?php if (isset($typeName)) {
                    $row = mysqli_fetch_array($typeName); ?>
                    <span>></span>
                    <span><?php echo $row['name']; ?></span>
                <?php } ?>
                <?php if (isset($categoryTypeName)) {
                    $row = mysqli_fetch_array($categoryTypeName); ?>
                    <span>></span>
                    <span><?php echo $row['type_name']; ?></span>
                    <span>></span>
                    <span><?php echo $row['category_name']; ?></span>
                <?php } ?>
            </p>

            <div class="product-detail" style="margin-top:20px">
                <?php while ($row = mysqli_fetch_array($products)) { ?>
                    <div class="item">
                        <a href="<?php echo WEBROOT . 'product/detail/' . $row['product_code']; ?>">
                            <img src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image'] ?>" alt="">
                        </a>
                        <a href="<?php echo WEBROOT . 'product/detail/' . $row['product_code']; ?>">
                            <p style="font-size: 12px;"> <?php echo $row['name'] ?> </p>
                        </a>
                        <p>
                            <a href="<?php echo WEBROOT . 'product/detail/' . $row['product_code']; ?>"
                               style="color:green; font-weight:bold;">
                                VND <?php echo number_format($row['price'], 0, ',', '.'); ?>đ
                            </a>
                        </p>
                        <form action="/inis/cart/addItem/<?php echo $row['product_code']; ?>" method="POST">
                            <input type="hidden" name="product_code" value="<?= htmlspecialchars($row['product_code']) ?>">
                            <button type="submit" class="buy-now">Add to cart</button>
                            <?php
                            if (isset($_SESSION['flash_message'])) {
                                echo "<div id='flash-message' class='flash-message'>" . $_SESSION['flash_message'] . "</div>";
                                unset($_SESSION['flash_message']);
                            }
                            ?>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Hiệu ứng hover cho .loai-wrapper
        $(".loai-wrapper").mouseenter(function () {
            $(this).find(".chanhocx2").stop(true, true).fadeIn(200);
        }).mouseleave(function () {
            setTimeout(() => {
                if (!$(this).find(".chanhocx2:hover").length) {
                    $(this).find(".chanhocx2").stop(true, true).fadeOut(200);
                }
            }, 200);
        });

        $(".chanhocx2").mouseleave(function () {
            $(this).stop(true, true).fadeOut(200);
        });

        // Show flash message
        if ($('#flash-message').length > 0) {
            $('#flash-message').addClass('show');
            setTimeout(function () {
                $('#flash-message').fadeOut(500);
            }, 5000);
        }
    });
</script>

</body>
</html>
