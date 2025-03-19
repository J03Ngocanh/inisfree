<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?php echo WEBROOT; ?>public/huhu.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        input, a {
            font-family: "Nunito", sans-serif;
        }

        #search {
            width: 80%;
        }

        body {
            font-family: "Nunito", sans-serif;
        }

        .duong_dan ul li .dropdown-menu {
            display: none;
        }

        .search-bar {
            position: relative;
            width: 400px;; /* Tùy chỉnh theo yêu cầu */
            align-items: center;
        }

        .menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Đảm bảo menu luôn ở trên cùng */
            background-color: white; /* Đảm bảo nền trắng cho menu */
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Tạo hiệu ứng bóng cho menu */
        }

        #search {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }

        #search:focus {
            border-color: #6b8e23; /* Focus border */
            box-shadow: 0 0 5px rgba(107, 142, 35, 0.5);
        }

        .icon-menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 3%;
        }

        .icon-menu span {
            white-space: nowrap; /* Đảm bảo không xuống dòng */
            font-size: 15px;
            color: #333;
        }

        .icon-menu p {
            margin: 0;
            padding: 0 5px;
            white-space: nowrap; /* Đảm bảo không xuống dòng */
        }

        .icon-menu a {
            white-space: nowrap; /* Đảm bảo không xuống dòng */
            text-decoration: none;
            color: #333;
            font-size: 15px;
            transition: color 0.3s;
        }

        .icon-menu a:hover {
            color: #6b8e23; /* Đổi màu khi hover */
        }

        #search-results {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            background-color: #fff;
            z-index: 9999;
            border-radius: 4px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
        }

        #search-results div {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #search-results div img {
            width: 30px;
            height: auto;
            margin-right: 10px; /* Khoảng cách giữa ảnh và tên sản phẩm */
            border-radius: 4px; /* Thêm góc bo tròn nhẹ */
        }

        #search-results div:hover {
            background-color: #f0f8ff;
        }

        #search-results div:not(:last-child) {
            border-bottom: 1px solid #f0f0f0;
        }

        /* Cart icon */
        .cart-icon {
            position: relative;
            display: inline-block;
            font-size: 22px;
            color: #333;
            transition: color 0.3s ease;
        }

        .icon i {
            font-size: 25px;
        }


        /* Cart count badge */
        .cart-count {
            position: absolute;
            top: -5px;
            right: -8px;
            background-color: rgb(158, 254, 187);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Hide count when empty */
        .cart-count:empty {
            display: none;
        }


        .noi-dung {
            margin-top: 80px;
        }

        .points-container {
            display: inline-flex;
            align-items: center;
            background: rgb(216, 250, 210);
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin-left: 10px;
        }

        .points-container i {
            margin-right: 5px;
            font-size: 16px;
        }


    </style>
</head>
<body>

<div class="snow-container"></div>

<div class='back'>
    <div class='menu'>
        <div class="logo">
            <a href="<?php echo WEBROOT; ?>home/home">
                <img style="width: 200px; height: auto;" src='<?php echo WEBROOT; ?>public/img/innis.png'>
                <img style="width:30px; height:auto; left:215px;" class="hat-icon"
                     src="<?php echo WEBROOT; ?>public/img/hat.png" alt="hat">
            </a>
        </div>
        <div class="nav-path">
            <ul>
                <li><a href="<?php echo WEBROOT; ?>home/profile">My Page</a></li>
                <li><a href="<?php echo WEBROOT; ?>veinnis/veinnis">About Innisfree</a></li>
                <li class="dropdown">
                    <a href="<?php echo WEBROOT; ?>product/index">Products</a>
                    <ul class="dropdown-menu">
                        <?php while ($row = mysqli_fetch_array($productTypes)) { ?>
                            <li style=" text-transform: capitalize; font-size: 15px; padding:1px; margin:1px;">
                                <a href="/inis/product/byType/<?php echo $row['id'] ?>"><?php echo $row['name']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

            </ul>
        </div>

        <!-- Search and cart icons -->
        <div class="icon-menu">
            <div class="search-bar">
                <form id="search-form" action="/inis/product/processSearch" method="post">
                    <input type="text" id="search" name="q" placeholder="Search products...">
                    <div id="search-results"
                         style="position: absolute; background: white; border: 1px solid #ccc; width: 100%; z-index: 999;"></div>
                </form>
            </div>

            <!-- Cart count -->
            <?php
            $cartCount = 0;
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $cartCount += $item['quantity'];
                }
            }
            ?>

            <!-- Cart icon with count -->
            <a href="<?php echo WEBROOT; ?>cart/index" class="icon cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-count"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>

            <?php if (isset($_SESSION['customer_name']) && !empty($_SESSION['customer_name'])): ?>
                <!-- Logged in -->
                <span><strong><?= htmlspecialchars($_SESSION['customer_name']); ?></strong></span>
                <div class="points-container">
                    🪙
                    <?php if (isset($info) && $row = $info->fetch_assoc()): ?>
                        <span><?php echo $row['point'] ?? 0; ?> points</span>
                    <?php else: ?>
                        <span>0 points</span>
                    <?php endif; ?>
                </div>
                <p>|</p>
                <a style="font-size:15px;" href="<?php echo WEBROOT; ?>account/logout" class="icon">Logout</a>
            <?php else: ?>
                <!-- Not logged in -->
                <a href="<?php echo WEBROOT; ?>account/login" class="icon"><i class="fas fa-user"></i></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="main-content"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById("search").addEventListener("keyup", function () {
        const query = this.value.trim();
        const searchResults = document.getElementById("search-results");

        if (query.length > 0) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/inis/product/searchSuggest", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResults.innerHTML = xhr.responseText;
                    searchResults.style.display = "block";
                }
            };

            xhr.send("nd=" + encodeURIComponent(query));
        } else {
            searchResults.innerHTML = "";
            searchResults.style.display = "none";
        }
    });

    document.getElementById("search-results").addEventListener("click", function (event) {
        const target = event.target;
        if (target.tagName === "DIV") {
            document.getElementById("search").value = target.innerText; // Gán tên sản phẩm vào input
            this.innerHTML = "";
            this.style.display = "none";
        }
    });

    function updateCartCount() {
        $.ajax({
            url: '<?php echo WEBROOT; ?>cart/getCartCount',
            type: 'GET',
            success: function (response) {
                var count = parseInt(response);
                var cartCountElement = $('.cart-count');

                if (count > 0) {
                    cartCountElement.text(count).show();
                } else {
                    cartCountElement.hide();
                }
            },
            error: function () {
                console.log('Lỗi khi lấy số lượng giỏ hàng');
            }
        });
    }

    // Cập nhật số lượng ngay khi trang tải
    updateCartCount();


</script>
</body>
</html>
