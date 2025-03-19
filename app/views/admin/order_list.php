<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
</head>
<style>
    /* Order details popup */
    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none; /* Mặc định ẩn */
        justify-content: center;
        align-items: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Popup content */
    .popup-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 60%;
        max-width: 700px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: slideDown 0.3s ease-in-out;
    }

    /* Close button */
    .close {
        font-size: 24px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 15px;
        transition: color 0.3s ease-in-out;
    }

    .close:hover {
        color: #000;
    }

    /* Order table in popup */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table-header {
        background-color: #f2f2f2;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        padding: 12px;
        border-bottom: 2px solid #ddd;
    }

    .table-row {
        display: flex;
        justify-content: space-between;
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    .table-row:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table-row:hover {
        background-color: #eef;
    }

    .table-cell {
        flex: 1;
        padding: 10px;
        text-align: left;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
    }

    th {
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        font-weight: bold;
    }

    td {
        color: #333;
        font-size: 14px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    /* Product image */
    .table-cell img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        margin-left: 10px;
        border-radius: 5px;
    }

    /* Popup button */
    .popup button {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 15px;
        display: block;
        width: 100%;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out;
    }

    .popup button:hover {
        background-color: #2980b9;
    }

    #products {
        flex: 3; /* Tăng độ rộng cho cột sản phẩm */
        gap: 5%;
    }

    .edit-btn {
        background-color: #16A085;
        color: white;
        border: none;
        padding: 4px 4px;
        border-radius: 6px;
        cursor: pointer;
    }


    /* Hiệu ứng mở popup */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

</style>
<body>
<div class="detail">
    <main class="main-content">
        <!-- Sections -->

        <h2 style="text-align: center;">Order List</h2>
        <table>
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Recipient</th>
                <th>Phone</th>
                <th>Delivery address</th>
                <th>Payment</th>
                <th>Total</th>
                <th>Order date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            while ($row = mysqli_fetch_array($orderList)) {
                mysqli_data_seek($ctddh, 0);

                ?>
                <tr>
                    <td><?php echo $row['order_code'] ?></td>
                    <td><?php echo $row['recipient_name'] ?></td>
                    <td><?php echo $row['recipient_phone'] ?></td>
                    <td><?php echo $row['recipient_address'] ?></td>
                    <td><?php if (($row['pttt'] ?? $row['payment_method'] ?? '') == "tien_mat" || ($row['pttt'] ?? $row['payment_method'] ?? '') == "cash") {
                            echo "Cash";
                        } elseif (($row['pttt'] ?? $row['payment_method'] ?? '') == "chuyen_khoan" || ($row['pttt'] ?? $row['payment_method'] ?? '') == "bank_transfer") {
                            echo "Bank transfer";
                        } else {
                            echo "VNPay QR";
                        } ?></td>

                    <td><?php echo number_format($row['total'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo $row['created_at'] ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td>
                        <?php if ($row['status'] == "new") { ?>
                            <a href="/inis/admin/confirmOrder/<?php echo $row['order_code'] ?>"
                               id="confirm-link-<?php echo $row['order_code'] ?>">
                                <button class="btn edit-btn">Confirm</button>
                            </a>
                        <?php } ?>
                        <button onclick="openPopup('<?php echo $row['order_code']; ?>')"
                                style="background-color: #16A085; color: white; border: none; padding: 4px 4px; border-radius: 6px; cursor: pointer;">
                            Details
                        </button>
                    </td>

                </tr>

                <!-- Order details popup -->
                <div id="orderDetailsPopup<?php echo $row['order_code']; ?>" class="popup">
                    <div class="popup-content">
                        <span class="close" onclick="closePopup('<?php echo $row['order_code']; ?>')">&times;</span>
                        <h2>Order details - Code: <?php echo $row['order_code']; ?></h2>
                        <div class="table">
                            <div class="table-header">
                                <div class="table-cell" id="products">Product</div>
                                <div class="table-cell">Unit price</div>
                                <div class="table-cell">Quantity</div>
                            </div>

                            <?php while ($rowctsp = mysqli_fetch_array($orderDetails)) { ?>
                                <?php if ($rowctsp['order_id'] == $row['order_code']) { ?>
                                    <div class="table-row">
                                        <div class="table-cell" id="products" style="display:flex">
                                            <img style="width: 80px; height: 80px;"
                                                 src="<?php echo WEBROOT . 'public/img/' . $rowctsp['image']; ?>"
                                                 alt="">
                                            <?php echo $rowctsp['name'] ?>
                                        </div>
                                        <div class="table-cell"><?php echo number_format($rowctsp['unit_price'], 0, '', ','); ?>
                                            ₫
                                        </div>
                                        <div class="table-cell"><?php echo $rowctsp['quantity'] ?></div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <button onclick="closePopup('<?php echo $row['order_code']; ?>')"
                                style="background-color: #3498DB; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer;">
                            Close
                        </button>
                    </div>
                </div>
                <?php $i++;
            } ?>
            </tbody>
        </table>

        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<script>alert('" . addslashes($_SESSION['success_message']) . "');</script>";
            unset($_SESSION['success_message']);
        }
        ?>

    </main>
</div>
</div>
<script>
    function confirmCustom(message) {
        const isConfirmed = window.confirm(message);
        return isConfirmed;
    }

    // Show popup by order ID
    function openPopup(mahd) {
        const popup = document.getElementById('orderDetailsPopup' + mahd);
        popup.style.display = 'flex';
    }

    // Close popup
    function closePopup(mahd) {
        const popup = document.getElementById('orderDetailsPopup' + mahd);
        popup.style.display = 'none';
    }

</script>
</body>
</html>

