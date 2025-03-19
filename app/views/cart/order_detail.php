<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Order Success</title>
</head>
<body>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            color: #e60012;
        }

        .order-info {
            margin-top: 20px;
        }

        .order-info div {
            margin-bottom: 10px;
        }

        .summary-box {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #eaffea;
        }

        .summary-box h3 {
            margin-top: 0;
            color: #2a7e2a;
        }

        .summary-box ul {
            list-style-type: none;
            padding: 0;
        }

        .summary-box ul li {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .summary-box ul li::before {
            content: "✔";
            margin-right: 10px;
            color: #2a7e2a;
        }

        .note {
            margin-top: 20px;
        }

        .note textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<br>
<br>
<br>
<div class="container">
    <h2>Order Details</h2>

    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit price</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($data = mysqli_fetch_array($orderItemsInfo)) { ?>
            <tr>
                <td><?php echo $data['name']; ?></td>
                <td><?php echo $data['quantity']; ?></td>
                <td><?php echo number_format($data['price'], 0, ',', '.'); ?> VNĐ</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="order-info">
        <?php while ($row = mysqli_fetch_array($orderInfo)){ ?>
        <div>Payment method: <strong><?php if ($row['payment_method'] == "tien_mat" || $row['payment_method'] == "cash") {
                    echo "Cash";
                } elseif ($row['payment_method'] == "chuyen_khoan" || $row['payment_method'] == "bank_transfer") {
                    echo "Bank transfer";
                } else {
                    echo "VNPay QR";
                } ?></strong></div>
        <div>Total: <strong class="total"><?php echo number_format($row['total'], 0, ',', '.'); ?>
                VNĐ</strong></div>
    </div>

    <div class="order-info">

        <h3>Delivery Info & Address</h3>

        <div>Name: <strong><?php echo $row['recipient_name'] ?></strong></div>
        <div>Delivery address: <strong><?php echo $row['recipient_address'] ?></strong></div>
        <div>Phone: <strong><?php echo $row['recipient_phone'] ?></strong></div>
        <?php } ?>
    </div>

    <div class="summary-box">
        <h3>
            Thank you for your trust and support.
        </h3>

    </div>


</div>
</body>
</html>
</body>
</html>
