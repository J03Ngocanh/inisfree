<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        main {
            margin: 50px;
            font-family: "Nunito", sans-serif;
        }

        .category-sidebar {
            max-width: 300px;
        }

        li {
            list-style: none;
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
            display: flex;
            margin-bottom: 100px;
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

        .chanhocx2 {
            display: none;
            margin-left: 15px;
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
    </style>
</head>
<body>
<main>
    <div class="full">
        <div class="category-sidebar">
            <p style="font-size:22px; color:green; font-weight: bold;">Product category</p>
            <hr>
            <ul class="chanhoc">
                <?php while ($row = mysqli_fetch_array($loaisp)) { ?>
                    <li class="category-item">
                        <a href="/inis/product/byType/<?php echo $row['id_loaisp'] ?>"> <?php echo $row['tenloai']; ?> </a>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                        <ul class="chanhocx2">
                            <?php
                            mysqli_data_seek($categories, 0);
                            while ($huhu = mysqli_fetch_array($categories)) {
                                if ($huhu['id_loaisp'] == $row['id_loaisp']) { ?>
                                    <li>
                                        <a href="/inis/product/sanpham_danhmuc/<?php echo $huhu['id'] ?>"> <?php echo $huhu['name']; ?> </a>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="product">
            <p style="margin-top:22px;margin-bottom:22px;">
                <span>Products</span>
                <?php if (isset($tenloai)) {
                    $row = mysqli_fetch_array($tenloai); ?>
                    <span>></span>
                    <span><?php echo $row['tenloai']; ?></span>
                <?php } ?>
                <?php if (isset($tendanhmuc_loai)) {
                    $row = mysqli_fetch_array($tendanhmuc_loai); ?>
                    <span>></span>
                    <span><?php echo $row['tenloai']; ?></span>
                    <span>></span>
                    <span><?php echo $row['tendanhmuc']; ?></span>
                <?php } ?>
            </p>
            <hr>
            <div class="product-detail" style="margin-top:20px">
                <?php while ($row = mysqli_fetch_array($sanpham)) { ?>
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
</main>
<script>
    $(document).ready(function () {
        $(".toggle-icon").click(function () {
            $(this).siblings(".chanhocx2").slideToggle();
            $(this).parent().toggleClass("active");
        });
    });
</script>
</body>
</html>
