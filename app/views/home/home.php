<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innisfree</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        function closeBanner() {
            document.getElementById('promo-banner').style.display = 'none';
        }
    </script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .event-blog-section {
            margin: 0 auto;
            width: 80%;
            text-align: center;
            padding: 2%
            background-color: #f9f9f9;
        }

        .anh_giua, .anh_ngang, .anh_doc {
            flex: 1;
            text-align: center;
            max-width: 30%;
        }

        .section-title {
            font-size: 28px;
            color: green;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
            background: linear-gradient(to right, #008000, #008000);
            background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;

        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 4px;
            background: linear-gradient(to right, #008000, #008000);
            border-radius: 10px;
        }

        .blogs {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            padding: 3%;
        }

        .blog {
            width: 250px;
            cursor: pointer;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .blog img {
            width: 100%;
            height: auto;
        }

        .product-detail {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 25px;
            margin-top: 20px;
            padding: 0 5%;
            justify-content: center;
            align-items: center;
        }

        .item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;

        }

        .item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .item img {
            width: 70%;
            height: auto;
            object-fit: cover;
        }

        .member-benefits {
            background-color: #f9f9f9;
            text-align: center;
            padding: 3%;
        }

        .benefits-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .benefit-item {
            text-align: center;
            width: 200px;
            transition: transform 0.3s ease;

        }

        .benefit-item:hover {
            transform: scale(1.1);
        }

        .benefit-item .icon {
            border: 2px solid #139b43;
            border-radius: 50%;
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .buy-now {
            background-color: #139b43;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
           margin: 10px;
        }

        #shop-now button:hover {
            background-color: darkgreen;
        }

        .benefit-item .icon img {
            width: 40px;
            height: 40px;
            transition: transform 0.3s ease;
        }

        .benefit-item:hover .icon img {
            transform: scale(1.2);
        }

        .flash-sale {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px;
        }

        .flash-sale h2 {
            color: #e60000;
            font-size: 24px;
        }

        .countdown-timer {
            margin: 20px 0;
            font-size: 18px;
        }

        .product-list {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .product {
            width: 200px;
            padding: 10px;
            margin: 10px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-name {
            font-weight: bold;
            margin-top: 10px;
        }

        .product-price {
            text-decoration: line-through;
            color: #888;
        }

        .flash-sale-price {
            color: #e60000;
            font-weight: bold;
        }

        button {
            background-color: #e60000;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .buy-now:hover {
            background-color: rgb(255, 255, 255);
            color: #28a745;
            border-color: #28a745;
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

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Làm tối nền */

            display: flex; /* Kích hoạt flexbox */
            justify-content: center; /* Căn giữa theo chiều ngang */
            align-items: center; /* Căn giữa theo chiều dọc */

            z-index: 9999; /* Đảm bảo hiển thị trên cùng */
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
            position: relative;
            animation: fadeIn 0.5s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        .rank-icon {
            width: 80px;
            margin-top: 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        @keyframes slide-in {
            0% {
                top: -50px;
            }
            100% {
                top: 10px;
            }
        }


        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .product-detail {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }

            .blogs {
                flex-direction: column;
                align-items: center;
            }

            .blog {
                width: 90%;
            }
        }

        @media screen and (max-width: 480px) {
            .section-title {
                font-size: 24px;
            }

            .blogs {
                padding: 3%;
            }

            .product-detail {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .benefit-item {
                width: 100%;
            }
        }

        /* Promo banner */
        #promo-banner {
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
        }

        /* Banner text */
        #promo-banner span {
            display: inline-block;
            margin-right: 15px;
            font-size: 18px;
        }

        @keyframes slideBanner {
            0% {
                left: 100%;
            }
            100% {
                left: -100%;
            }
        }

        /* Close button */
        button {
            margin-left: 10px;
            border: none;
            background: none;
            cursor: pointer;
        }

        #flag {
            width: 50px;
            height: auto;
            vertical-align: middle;
            margin-right: 10px;
        }
        #messages {
            height: 80%;
            overflow-y: auto;
            margin-bottom: 10px;
        }
        #input {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        #messages p {
            margin: 5px 0;
        }
        #messages p b {
            color: #12b560;
        }
        #chat-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            background-color:rgb(33, 253, 13);
            color: white;
            border-radius: 50%;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1001;
        }

        /* Chat box */
        #chatbox {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 360px;
            max-height: 500px;
            border: 1px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background-color: #f9f9f9;
            display: none;
            flex-direction: column;
            font-family: Arial, sans-serif;
            z-index: 1000;
            overflow: hidden;
        }

        /* Category step */
        #category-step {
            padding: 16px;
            background-color: #fafafa;
            flex: 1;
            display: flex;
            flex-direction: column;
            text-align: center;
            border-bottom: 1px solid #eee;
            overflow-y: auto;
        }

        #category-options {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        #category-options button {
            padding: 8px 14px;
            background-color:rgb(194, 234, 183);
            color: black;
            border: none;
            border-radius: 18px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #category-options button:hover {
            background-color:rgb(4, 49, 8);
            color: white;
        }

        /* Chat area */
        #chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Chat log */
        #chat-log {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background-color: #fff;
            border-bottom: 1px solid #eee;
            scroll-behavior: smooth;
            max-height: 300px;
        }

        /* Messages */
        #chat-log p {
            margin: 8px 0;
            padding: 10px 14px;
            border-radius: 20px;
            max-width: 80%;
            word-wrap: break-word;
        }

        #chat-log .user {
            background-color: #d1e7dd;
            align-self: flex-end;
            text-align: right;
            margin-left: auto;
        }

        #chat-log .bot {
            background-color: #f8d7da;
            align-self: flex-start;
            text-align: left;
            margin-right: auto;
        }

        /* Input area */
        #chat-step {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }

        #chat-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 14px;
            outline: none;
        }

        #chat-step button {
            margin-left: 10px;
            padding: 10px 18px;
            background-color: #198754;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #chat-step button:hover {
            background-color: #146c43;
        }
   

/* Tooltip */
#chat-toggle .chat-tooltip {
    visibility: hidden;
    background-color: #343a40;
    color: #fff;
    text-align: center;
    border-radius: 10px;
    padding: 6px 12px;
    position: absolute;
    bottom: 60px;
    left: -220px; /* Di chuyển tooltip sang trái */
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 14px;
    pointer-events: none;
}

/* Hover để hiện tooltip + hiệu ứng phóng to */
#chat-toggle:hover {
    transform: scale(1.1);
}

#chat-toggle:hover .chat-tooltip {
    visibility: visible;
    opacity: 1;
}

    </style>
</head>
<body>

<?php
if (isset($_SESSION['login_error'])) {
    unset($_SESSION['login_error']);
}
?>

<div class="noi-dung">

    <!-- Hình ảnh slider -->
    <div class='anh_giua'>
        <img src="<?php echo WEBROOT; ?>public/img/anh_giua.jpeg" alt="anh giua">
    </div>
    <div class='anh_ngang'>
        <img src="<?php echo WEBROOT; ?>public/img/anh_ngang.jpg" alt="anh ngang">
    </div>
    <div class='anh_doc'>
        <img src="<?php echo WEBROOT; ?>public/img/anh_doc.jpg" alt="anh doc">
    </div>

    <div class="slider" style="display: flex;">
        <div class='left'>
            <div class="slogan" style="margin-top:-40px;">
                <p style="font-size: 26px">"Effective, nature-powered </p>
                <p style="text-transform: uppercase;font-weight:bolder; font-size:50px; margin-top: -30px; letter-spacing: 5px;">skincare </p>
                <p style="margin-top:-60px">discovered from the island"</p>
                <p style="font-size: 17px; font-style: italic;  text-align: justify; max-width: 100%">
                    Innisfree, the pure island where clean nature and healthy beauty coexist in harmony. Innisfree is a natural brand that shares the benefits of nature from the pristine island of Jeju allowing for vibrant beauty and pursues an eco-friendly green life to preserve the balance of nature
                </p>
            </div>
            <div id="shop-now">
                <a href="<?php echo WEBROOT . 'product/index' ?>">
                    <button>SHOP NOW</button>
                </a>
            </div>
        </div>
        <div class='right'></div>
    </div>
    <div id="chat-toggle">
    💬
    <span class="chat-tooltip">Hi, how can I help you?</span>
</div>


    <!-- Hộp chat -->
    <div id="chatbox">
        <!-- Bước chọn danh mục -->
        <div id="category-step">
            <p><b>What would you like help with?</b></p>
            <div id="category-options"></div>
        </div>

        <!-- Bước trò chuyện -->
        <div id="chat-area" style="display: none; flex: 1; flex-direction: column;">
            <div id="chat-log"></div>
            <div id="chat-step">
                <input type="text" id="chat-input" placeholder="Enter your question...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
    <!-- BEST SELLER -->
    <section class="event-blog-section">
        <h2 class="section-title">BEST SELLER</h2>
        <div class="product-detail" style="margin-top:20px">
            <?php while ($row = mysqli_fetch_array($bestSellers)) { ?>
                <div class="item">
                    <a href="<?= WEBROOT . 'product/detail/' . $row['product_code']; ?>">
                        <img src="<?= WEBROOT; ?>public/img/<?= $row['image'] ?>" alt="">
                    </a>
                    <a href="<?= WEBROOT . 'product/detail/' . $row['product_code']; ?>">
                        <p style="font-size: 12px;"><?= $row['name'] ?></p>
                    </a>
                    <p style="margin-top:-5px;">
                        <a href="<?= WEBROOT . 'product/detail/' . $row['product_code']; ?>" style="color:green; font-weight:bold;">
                            VND <?= number_format($row['price'], 0, ',', '.'); ?>đ
                        </a>
                    </p>
                    <form action="/inis/cart/addItem/<?= $row['product_code']; ?>" method="POST">
                        <input type="hidden" name="product_code" value="<?= htmlspecialchars($row['product_code']) ?>">
                        <button type="submit" class="buy-now">Add to cart</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- NEW ITEMS -->
    <section class="event-blog-section">
        <h2 class="section-title">NEW ITEMS</h2>
        <div class="product-detail" style="margin-top:20px">
            <?php while ($row = mysqli_fetch_array($newItems)) { ?>
                <div class="item">
                    <a href="<?= WEBROOT . 'product/detail/' . $row['product_code']; ?>">
                        <img src="<?= WEBROOT; ?>public/img/<?= $row['image'] ?>" alt="">
                    </a>
                    <a href="<?= WEBROOT . 'product/detail/' . $row['product_code']; ?>">
                        <p style="font-size: 12px;"><?= $row['name'] ?></p>
                    </a>
                    <p style="margin-top:-5px;">
                        <a href="<?= WEBROOT . 'product/detail/' . $row['product_code']; ?>" style="color:green; font-weight:bold;">
                            VND <?= number_format($row['price'], 0, ',', '.'); ?>đ
                        </a>
                    </p>
                    <form action="/inis/cart/addItem/<?= $row['product_code']; ?>" method="POST">
                        <input type="hidden" name="product_code" value="<?= htmlspecialchars($row['product_code']) ?>">
                        <button type="submit" class="buy-now">Add to cart</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- EVENT BLOG -->
    <section class="event-blog-section">
        <h2 class="section-title">EVENT BLOG</h2>
        <div class="blogs">
            <div class="blog" data-id="blog1">
                <a href="<?= WEBROOT; ?>veinnis/blog1">
                    <img src="<?= WEBROOT; ?>public/img/blog1.png" alt="blog1">
                </a>
            </div>
            <div class="blog" data-id="blog2">
                <a href="<?= WEBROOT; ?>veinnis/blog2">
                    <img src="<?= WEBROOT; ?>public/img/blog2.png" alt="blog2">
                </a>
            </div>
        </div>
    </section>

    <!-- CHÍNH SÁCH -->
    <section class="event-blog-section">
        <div class="member-benefits">
            <h2 class="section-title">POLICY</h2>
            <div class="benefits-container">
                <?php
                $chinhSach = [
                    ['muahang', '1.png', 'Purchase Policy'],
                    ['trahang', '2.png', 'Return Policy'],
                    ['giaohang', '3.png', 'Delivery Service'],
                    ['pttt', '4.png', 'Payment Methods'],
                ];
                foreach ($chinhSach as [$slug, $img, $label]) {
                    echo "<div class='benefit-item'>
                            <a href='" . WEBROOT . "policy/$slug'>
                                <div class='icon'><img src='" . WEBROOT . "public/img/$img' alt='$label'></div>
                                <p>$label</p>
                            </a>
                        </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- POPUP thăng hạng -->
    <?php if (isset($rank_up)): ?>
        <div id="rankUpPopup" class="popup">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <h2>🎉 Congratulations! 🎉</h2>
                <p>You have been promoted to <strong><?= getRankName($rank_up); ?></strong>!</p>
                <img style="width: 100px;" src="<?= WEBROOT; ?>public/img/rank_<?= $rank_up; ?>.png" alt="New rank" class="rank-icon">
            </div>
        </div>
    <?php endif; ?>

</div> <!-- .noi-dung -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= WEBROOT; ?>java/script.js"></script>
<script>
    $(document).ready(function () {
        if ($('#flash-message').length > 0) {
            $('#flash-message').addClass('show');
            setTimeout(function () {
                $('#flash-message').fadeOut(500);
            }, 5000);
        }

        $("#rankUpPopup").show();
        $(".close-btn").click(function () {
            $("#rankUpPopup").hide();
        });
    });

    let selectedCategory = "";

    function renderCategories(categories) {
        const container = document.getElementById("category-options");
        container.innerHTML = "";

        categories.forEach(cat => {
            const btn = document.createElement("button");
            btn.textContent = cat.name;
            btn.onclick = () => selectCategory(cat.id, cat.name);
            btn.style.margin = "5px";
            container.appendChild(btn);
        });
    }

    function selectCategory(id, name) {
        selectedCategory = id;

        const log = document.getElementById("chat-log");
        log.innerHTML += `<div><b>Bot:</b> You chose advice on <i>${name}</i>. Please ask your question.</div>`;

        document.getElementById("category-step").style.display = "none";
        document.getElementById("chat-area").style.display = "flex";
    }

    function sendMessage() {
        const msg = document.getElementById("chat-input").value.trim();
        if (msg === '' || selectedCategory === '') return;

        const log = document.getElementById("chat-log");
        log.innerHTML += `<div><b>You:</b> ${msg}</div>`;

        fetch('<?php echo WEBROOT; ?>chat/chat', {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ message: msg, category: selectedCategory })
        })
            .then(res => res.text())
            .then(data => {
                log.innerHTML += `<div><b>Bot:</b> ${data}</div>`;
                log.scrollTop = log.scrollHeight;
                document.getElementById("chat-input").value = "";
            });
    }
    document.getElementById("chat-input").addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            sendMessage();
            document.getElementById("chat-input").value = ""; // Clear input
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        fetch('<?php echo WEBROOT; ?>chat/categories') // API trả về danh mục
            .then(res => res.json())
            .then(data => renderCategories(data));
    });
    document.getElementById("chat-toggle").addEventListener("click", () => {
        const chatbox = document.getElementById("chatbox");
        if (chatbox.style.display === "flex") {
            chatbox.style.display = "none";
        } else {
            resetChatbox(); // Gọi hàm reset khi mở lại
            chatbox.style.display = "flex";
        }
    });
    // Mặc định ẩn chatbox
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('chatbox').style.display = 'none';
    });

    function resetChatbox() {
        selectedCategory = "";
        document.getElementById("chat-input").value = "";
        document.getElementById("chat-log").innerHTML = "";
        document.getElementById("chat-area").style.display = "none";
        document.getElementById("category-step").style.display = "flex";

        // Gọi lại API để hiển thị lại danh mục
        fetch('<?php echo WEBROOT; ?>chat/categories')
            .then(res => res.json())
            .then(data => renderCategories(data));
    }
</script>

<?php
function getRankName($rank_id)
{
    $ranks = [
        1 => "Member",
        2 => "Silver",
        3 => "Gold",
        4 => "Diamond"
    ];
    return $ranks[$rank_id] ?? "Member";
}
?>
</body>
</html>
