<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

        body {
            font-family: "Nunito", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            display: flex;
            justify-content: space-between;
            gap: 8%;
            margin: 0 auto;
            max-width: 90%;
        }

        .left-section {

        }

        .right-section {
            width: 48%;
            background-color: rgb(194, 221, 188);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        /* Order Details */
        .order-details {
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
        }

        .order-item {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .order-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .order-summary {
            margin-top: 20px;
        }

        .order-summary p {
            font-size: 16px;
            color: #555;
        }

        .order-summary strong {
            font-size: 18px;
            color: #e60012;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #fafafa;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #6c63ff;
            background-color: #fff;
        }

        textarea {
            resize: vertical;
            height: 120px;
        }

        /* Flexbox for radio and label */
        .radio-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;         }

        .radio-group input[type="radio"] {
            margin-right: 10px;
        }

        .radio-group label {
            font-size: 16px;
            margin-right: 20px;         }

       
        .form-group input#payment_cash, input#payment_bank, input#payment_vnpay {
            width: 30%;
        }

        /* Button Styling */
        button {
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;

        }

        button:hover {
            background-color: #218838;
        }

        /* Popup Styling */
        #qr-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            width: 100%;
            height: 100%;
            display: none;
        }

        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .popup-content button {
            background-color: #f6a5ae;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .popup-content button:hover {
            background-color: #e60012;
        }

        #qrcode img {
            object-fit: contain;
            width: 100%;
            height: auto;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            border-top: 2px solid #000;
        }

        tr:last-child td {
            border-bottom: 2px solid #000;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

    </style>
</head>
<body>


<form id="checkout-form" action="<?= WEBROOT ?>cart/processCheckout/" method="POST">
    <div class="container">
        <div class="left-section">
            <h2>Product Info</h2>
            <table cellspacing="0" cellpadding="8">
                <thead>
                <tr>
                    <th></th>
                    <th>Product</th>
                    <th>Unit price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php $subtotal = 0; ?>
                <?php foreach ($buyNowProduct as $row): ?>
                    <tr>
                        <td><img style="width: 40px;"
                                 src="<?php echo WEBROOT; ?>public/img/<?php echo $row['image'] ?>" alt="product">
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><?php echo $quantity ?></td>
                        <td><?php echo number_format($row['price'] * $quantity, 0, ',', '.'); ?></td>
                    </tr>
                    <?php $subtotal += $row['price'] * $quantity; ?>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4"><strong>Subtotal:</strong></td>
                    <td><strong><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</strong></td>
                </tr>

                <?php
                $discountPercent = 0;
                while ($row = $coupon->fetch_assoc()):
                    $discountPercent = $row['discount'];
                    ?>
                    <tr>
                        <td colspan="4">Discount rate:</td>
                        <td><?php echo $discountPercent; ?>%</td>
                    </tr>
                <?php endwhile; ?>

                <?php
                $discountAmount = ($subtotal * $discountPercent) / 100;
                $shippingFee = 30000;
                $totalToPay = max(($subtotal - $discountAmount) + $shippingFee, 0);
                ?>

                <tr>
                    <td colspan="4">Discount amount:</td>
                    <td>-<?php echo number_format($discountAmount, 0, ',', '.'); ?> VND</td>
                </tr>

                <tr>
                    <td colspan="4">Shipping fee:</td>
                    <td><?php echo number_format($shippingFee, 0, ',', '.'); ?> VND</td>
                </tr>

                <tr>
                    <td colspan="4"><strong>Total:</strong></td>
                    <td><strong><?php echo number_format($totalToPay, 0, ',', '.'); ?> VND</strong></td>
                </tr>
                <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                <input type="hidden" name="discount" value="<?php echo $discountPercent; ?>">
                <input type="hidden" name="total_to_pay" value="<?php echo $totalToPay; ?>">

                </tfoot>

            </table>

        </div>
        <div class="right-section">
            <h2>Order information</h2>
            <div class="form-group">
                <label for="phone">Your phone number:</label>
                <input type="text" id="phone" name="phone" placeholder="Your phone number"
                       value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="recipient_name">Recipient name:</label>
                <input type="text" id="recipient_name" name="recipient_name" placeholder="Recipient name"
                       value="<?php echo isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : ''; ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="recipient_address">Delivery address:</label>
                <textarea id="recipient_address" name="recipient_address" rows="4" placeholder="Enter delivery address"
                          required></textarea>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment method:</label><br>
                <div class="radio-group">
                    <input type="radio" id="payment_cash" name="payment_method" value="cash" checked>
                    <label for="payment_cash">Cash on delivery</label><br>
                </div>

                <div class="radio-group">
                    <input type="radio" id="payment_bank" name="payment_method" value="bank_transfer">
                    <label for="payment_bank">Bank transfer</label><br>
                </div>
                <div class="radio-group">
                    <input type="radio" id="payment_vnpay" name="payment_method" value="vnpay_qr">
                    <label for="payment_vnpay">Pay via VNPAY</label><br>
                </div>
            </div>

            <div class="form-group" id="btn">
                <button type="submit" id="submit-btn">Confirm payment</button>
            </div>
        </div>
    </div>
    </div>
    <!-- QR code popup -->
    <div id="qr-popup" style="display: none;">
        <div class="popup-content">
            <h3>Scan QR code to pay</h3>
            <div id="qrcode"></div>
            <button type="button" class="close-btn">Close</button>
            <button type="button" class="submit">Complete payment</button>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("#checkout-form");
        const qrPopup = document.getElementById("qr-popup");
        const closeBtn = document.querySelector(".close-btn");
        const submitBtn = document.querySelector(".submit");
        const submitBtnElement = document.getElementById("submit-btn");
        let isPopupConfirmed = false;

        // Show QR code
        function showQRCode() {
            const qrImageUrl = `https://img.vietqr.io/image/970422-0923736453-compact2.png?amount=<?php echo $subtotal; ?>&addInfo=Order%20payment&accountName=Vu%20Nguyen%20Huong`;
            document.getElementById("qrcode").innerHTML = `<img src="${qrImageUrl}" alt="MB Bank QR" />`;
            qrPopup.style.display = "flex";
        }

        // Close popup on Close button
        closeBtn.addEventListener("click", function () {
            qrPopup.style.display = "none";
            isPopupConfirmed = false;
        });

        // Confirm payment on Complete button
        submitBtn.addEventListener("click", function () {
            if (form && form.id === "checkout-form") {
                isPopupConfirmed = true;
                qrPopup.style.display = "none";
                form.submit();
            }
        });

        // Confirm payment button click
        submitBtnElement.addEventListener("click", function (event) {
            const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethodInput) {
                alert("Please select a payment method!");
                event.preventDefault();
                return;
            }

            const paymentMethod = paymentMethodInput.value;
            if (paymentMethod === "bank_transfer" && !isPopupConfirmed) {
                event.preventDefault();
                showQRCode();
            }
        });
    });

</script>
</body>
</html>